<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'GabLab') }} - Invoice #{{ $id }}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link media="all" type="text/css" rel="stylesheet" href="{{ url('/themes/gablab/css/app.css') }}">
    </head>
    <body class="px-3">

        <table class="w-100 mb-4">
            <tr>
                <td class="align-middle text-primary">
                    <h1 class="mb-0"><span class="font-weight-bold">Gab</span>Lab</h1>
                </td>
                <td class="align-middle text-right">
                    <strong>Invoice #{{ $id }}</strong><br />
                    {{ Carbon::parse($created_at)->format('jS F Y') }}
                </td>
            </tr>
            <tr>
                <td class="my-2" colspan="2"><hr class="my-0" /></td>
            </tr>
            <tr>
                <td>
                    <h5>Client Information</h5>
                    <b>{{ $billing_first_name }} {{ $billing_last_name }}</b><br />
                    {{ $billing_address }},<br />
                    {{ $billing_city }} {{ $billing_zip }}, {{ $billing_country }}
                </td>
                <td class="text-right">
                    <h5>Payment Details</h5>
                    <b>GabLab</b><br />
                    Via Delle Madonne 53,<br />
                    Brindisi 72100 IT<br />
                    P.IVA EU 0000000000<br />
                </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th class="text-center">#</th>
                <th>Description</th>
                <th class="text-center">Price</th>
            </tr>
            <tr>
                <td class="text-center">{{ $id }}</td>
                <td>Platform Credits</td>
                <td class="text-center">${{ number_format($amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">
                    Total Amount:
                </td>
                <td class="text-center">
                    $ {{ number_format($amount, 2) }}
                </td>
            </tr>
        </table>

        
    </body>
</html>
