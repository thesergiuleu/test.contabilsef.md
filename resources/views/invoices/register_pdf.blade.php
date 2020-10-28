<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ro">
<body>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<div class="noprint"></div>
<style type="text/css">
    @media print {
        .noprint {
            display: none
        }
    }
    table {
        font-size: 14px;
        font-family: 'Times New Roman', Times, serif, sans-serif, DejaVu Sans;
    }

    table.brd {
        border-collapse: collapse;
    }

    table.brd td {
        border: 1px solid #000;
    }

    table.clr, table.clr td {
        border: none;
    }
</style>

<img src="{{ asset('assets/imgs/logo.png') }}" alt="ContabilSef Logo">
<br>

<table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tbody>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td>Furnizor:</td>
        <td><b>'Totul Pentru Contabil' SRL</b></td>
        <td align="center" rowspan="6" style="border-left: 1px solid;">
            FACTURA nr. - {{$postRegister->post->id}}

            <p>din {{ format_date($postRegister->created_at) }}</p>
        </td>
    </tr>
    <tr>
        <td>Adresa:</td>
        <td width="45%"><b>m.Chisinau, str.Valea Crucii 24, ap.41</b></td>
    </tr>
    <tr>
        <td>Tel:</td>
        <td>
            <b>224937</b>
        </td>
    </tr>
    <tr>
        <td>Cont de decontare:</td>
        <td>
            <b>IBAN: MD49MO2224ASV23423327100 la BC "Mobiasbanca-Groupe Societe Generale" SA</b>
        </td>
    </tr>
    <tr>
        <td>Cod:</td>
        <td>
            <b>MOBBMD22</b>
        </td>
    </tr>
    <tr>
        <td>Codul fiscal:</td>
        <td>
            <b>1007600050995</b>
        </td>
    </tr>

    </tbody>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="brd" style="margin-top:20px">
    <tbody>
    <tr>
        <td style="border-left:1px solid #000000;" colspan="3">Platitor, adresa: &nbsp;&nbsp;&nbsp;<b> {{ $postRegister->company_name ?: $postRegister->name}} {{ $postRegister->cod_fiscal }} </b>
            <br><br>
        </td>
    </tr>
    <tr>
        <td colspan="3">Destinatar: &nbsp;&nbsp;&nbsp;<b>'Totul Pentru Contabil' SRL </b></td>
    </tr>
    <tr>
        <td align="center">Denumirea</td>
        <td align="center">ID personal</td>
        <td align="center">Total</td>
    </tr>
    @if (isset($subscription))
        <tr>
            <td>{{ $subscription->display_type }}</td>
            <td align="center"><b>{{ $subscription->user_id }}</b></td>
            <td align="center"><b>{{ $subscription->price }} lei</b></td>
        </tr>
    @endif
    <tr>
        <td>Inregistrare seminar {{ $postRegister->post->title }}</td>
        <td align="center"></td>
        <td align="center"><b>{{ $price }} lei</b></td>
    </tr>
    <tr>
        <td colspan="1" style="border:0 none;"></td>
        <td colspan="1" style="border:0 none;">Total</td>
        <td align="center"><b>{{ isset($subscription) ? $subscription->price + $price : $price }} lei</b></td>
    </tr>
    </tbody>
</table>
<table border="0" cellpadding="3" cellspacing="0">
    <tbody>
    <tr>
        <td><br>Total pentru achitare: &nbsp;&nbsp; <b> {{ isset($subscription) ? $subscription->price + $price : $price }} lei.</b></td>
    </tr>
    <tr>
        <td align="left"></td>
    </tr>
    </tbody>
</table>

</body>
</html>
