<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlansRequest;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::all();
        return view('home.plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('home.plans.create');
    }

    public function subscriptions(Request $request): RedirectResponse
    {
        $plan = Plan::findOrFail($request->plan);

        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
            ->create($request->token);

        return redirect()->route('plans.index');
    }

    public function store(PlansRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        Plan::create($validatedData);

        return redirect()->route('plans.index')->with('status', 'plan Created Successfully');
    }

    public function show(Plan $plan, Request $request): View
    {
        $intent = auth()->user()->createSetupIntent();

        return view('home.plans.subscriptions', compact('plan', 'intent'));
    }

}
