<?php

namespace Fast\RequestLog\Listeners;

use Fast\RequestLog\Events\RequestHandlerEvent;
use Fast\RequestLog\Models\RequestLog;
use Auth;
use Illuminate\Http\Request;

class RequestHandlerListener
{
    /**
     * @var mixed
     */
    public $requestLog;

    /**
     * @var Request
     */
    protected $request;

    /**
     * RequestHandlerListener constructor.
     * @param RequestLog $requestLog
     * @param Request $request
     * @author Imran Ali
     */
    public function __construct(RequestLog $requestLog, Request $request)
    {
        $this->requestLog = $requestLog;
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  RequestHandlerEvent $event
     * @return boolean
     * @author Imran Ali
     */
    public function handle(RequestHandlerEvent $event)
    {
        if ($event->code == 404) {
            return false;
        }

        $this->requestLog = RequestLog::firstOrNew([
            'url'         => str_limit($this->request->fullUrl(), 120),
            'status_code' => $event->code,
        ]);

        if ($referrer = $this->request->header('referrer')) {
            $referrers = (array)$this->requestLog->referer ?: [];
            $referrers[] = $referrer;
            $this->requestLog->referer = $referrers;
        }

        if (Auth::check()) {
            if (!is_array($this->requestLog->user_id)) {
                $this->requestLog->user_id = [Auth::user()->getKey()];
            } else {
                $this->requestLog->user_id = array_unique(
                    array_merge($this->requestLog->user_id, [Auth::user()->getKey()])
                );
            }
        }

        if (!$this->requestLog->exists) {
            $this->requestLog->count = 1;
        } else {
            $this->requestLog->count += 1;
        }

        return $this->requestLog->save();
    }
}
