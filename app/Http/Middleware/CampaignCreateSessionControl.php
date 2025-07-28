<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CampaignCreateSessionControl
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!str($request->header('referer'))->contains($request->route()->compiled->getStaticPrefix())) {
            // If the referer is not from the campaign creation page, reset the session data
            session()->forget('campaigns::create');
        }else{
            $session = session('campaigns::create');
            $tab = $request->route('tab');

            // If the tab is not set, redirect to the create page
            if(filled($tab) && blank(data_get($session, 'name'))) {
                return to_route('campaigns.create');
            }

            //If tab is schedule but body is not set, redirect to template tab
            if($tab === 'schedule' && blank(data_get($session, 'body'))) {
                return to_route('campaigns.create', ['tab' => 'template']);
            }
        }
        return $next($request);
    }
}
