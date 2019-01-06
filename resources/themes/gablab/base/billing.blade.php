@extends('layouts.master')

@section('title')
    @lang('navigation.account.billing')
@endsection

@section('content-header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">@lang('navigation.account.billing')</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card card-body mb-4">
                <div class="row">
                    <div class="col-6 text-center">
                        <p class="font-weight-bold">@lang('base.billing.summary.this_month_charges')</p>   
                        <h2>@lang('currency.sym'){{ number_format($user->monthly_cost, 2) }}</h2>
                    </div>
                    <div class="col-6 text-center {{ $user->balance >= 0 ? 'text-success' : 'text-danger' }}">
                        <p class="font-weight-bold">@lang('base.billing.summary.account_balance')</p>  
                        <h2>@lang('currency.sym'){{ number_format($user->balance, 2) }}</h2> 
                    </div>
                </div>
            </div>
            <div class="card card-body mb-4">
                @if ($user->stripe_customer_id)
                    <h3>@lang('base.billing.unlink.heading')</h3>
                    <form method="POST" action="{{ route('account.billing.unlink') }}">
                        <p>@lang('base.billing.unlink.description', ['brand' => $user->stripe_card_brand, 'last4' => $user->stripe_card_last4])</p>
                        <div class="text-right">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-danger">@lang('base.billing.unlink.submit_button')</button>
                        </div>
                    </form>
                @else
                    <h3>@lang('base.billing.link.heading')</h3>
                    <form method="POST" action="{{ route('account.billing.link') }}">
                        <p>@lang('base.billing.link.description')</p>
                        <div class="form-group">
                            <label class="control-label">@lang('base.billing.link.credit_card_info')</label>
                            <div>
                                <div id="card-element"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('base.billing.link.amount')</label>
                            <div>
                                <input type="number" name="amount" value="20" class="form-control">
                            </div>
                        </div>
                        <div class="text-right">
                            <input type="hidden" name="card_token">
                            <input type="hidden" name="card_brand">
                            <input type="hidden" name="card_last4">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-outline-primary">@lang('base.billing.link.submit_button')</button>
                        </div>
                    </form>
                @endif
            </div>
            <div class="card card-body mb-4">
                <h3>@lang('base.billing.charge.heading')</h3>
                <form method="POST" action="{{ route('account.billing.paypal') }}">
                    <p>@lang('base.billing.charge.description')</p>
                    <div class="form-group">
                        <label class="control-label">@lang('base.billing.charge.amount')</label>
                        <div>
                            <input type="number" name="amount" value="20" class="form-control">
                        </div>
                    </div>
                    <div class="text-right">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-outline-primary">@lang('base.billing.charge.submit_button')</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card card-body mb-4">
                <h3>@lang('base.billing.info.header')</h3>
                <form action="{{ route('account.billing.info') }}" method="POST">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="first_name" class="control-label">@lang('base.billing.info.first_name')</label>
                            <div>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->billing_first_name) }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="last_name" class="control-label">@lang('base.billing.info.last_name')</label>
                            <div>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->billing_last_name) }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="address" class="control-label">@lang('base.billing.info.address')</label>
                            <div>
                                <input type="text" class="form-control" name="address" value="{{ old('address', $user->billing_address) }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="city" class="control-label">@lang('base.billing.info.city')</label>
                            <div>
                                <input type="text" class="form-control" name="city" value="{{ old('city', $user->billing_city) }}" />
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="country" class="control-label">@lang('base.billing.info.country')</label>
                            <div>
                                <select name="country" class="form-control">
                                    <option selected disabled>--</option>
                                    @foreach ($countries as $code => $name)
                                        <option value="{{ $code }}" {{ old('country', $user->billing_country) == $code ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="zip" class="control-label">@lang('base.billing.info.zip')</label>
                            <div>
                                <input type="text" class="form-control" name="zip" value="{{ old('zip', $user->billing_zip) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-outline-primary">@lang('base.billing.info.submit_button')</button>
                    </div>
                </form>
            </div>
            <div class="card card-body mb-4">
                <h3>@lang('base.billing.invoices.heading')</h3>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>@lang('base.billing.invoices.amount')</th>
                        <th>@lang('base.billing.invoices.date')</th>
                        <th></th>
                    </tr>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td><b>#{{ $invoice->id }}</b></td>
                            <td>@lang('currency.sym') {{ number_format($invoice->amount, 2) }}</td>
                            <td>{{ date(__('strings.date_format'), strtotime($invoice->created_at)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('account.invoice.pdf', ['id' => $invoice->id]) }}"><i class="far fa-file-pdf"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
@endsection


@section('footer-scripts')
    @parent
    <script src="https://js.stripe.com/v3/"></script>
    <script type="application/javascript">
        var form = $('#card-element').closest('form');
        var stripe = Stripe('{{ env("STRIPE_PUBLIC_KEY") }}');
        var card = stripe.elements().create('card', {
            style: {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    padding: '.5em',
                    margin: {
                        top: '10px',
                    },
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'}
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        card.mount('#card-element');
        form.on('submit', function(ev) {
            var token = form.find('[name="card_token"]');
            if (token.val()) return true;
            ev.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) return alert(result.error.message);
                form.find('[name="card_brand"]').val(result.token.card.brand);
                form.find('[name="card_last4"]').val(result.token.card.last4);
                token.val(result.token.id);
                form.submit();
            });
            return false;
        })
    </script>
    <style>
        .StripeElement {
            background-color: white;
            height: 40px;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;}
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;}
        .StripeElement--invalid {
            border-color: #fa755a;}
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;}
        .AmountSelector {
            display: flex;}
    </style>
@endsection
