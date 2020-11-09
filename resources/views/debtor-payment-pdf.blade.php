<html lang="en">
  <head>
    <meta charset="utf-8" />

    <title>Contas de {{ $period->format('F') }}/{{ $year }} | {{ $debtor->getName() }}</title>

    <style>
      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }

      body {
        font-family: Junge;
        position: relative;
        margin: 0 auto;
        color: #001028;
        background: #ffffff;
        font-size: 14px;
      }

      h1 {
        color: #5d6975;
        font-family: Junge;
        font-size: 2.4em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        border-top: 1px solid #5d6975;
        border-bottom: 1px solid #5d6975;
        margin: 0 0 2em 0;
      }

      h1 small {
        font-size: 0.45em;
        line-height: 1.5em;
        float: left;
      }

      h1 small:last-child {
        float: right;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 30px;
      }

      table th,
      table td {
        text-align: right;
      }

      table th {
        padding: 5px 20px;
        color: #5d6975;
        border-bottom: 1px solid #c1ced9;
        white-space: nowrap;
        font-weight: normal;
      }

      table ,
      table .desc {
        text-align: left;
      }

      table td {
        padding: 20px;
        text-align: right;
      }

      table td.desc {
        vertical-align: top;
        max-width: 20em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      table td.price,
      table td.qty,
      table td.total {
        font-size: 1.2em;
      }

      table td.grand {
        border-top: 1px solid #5d6975;
      }

      table tr:nth-child(2n-1) td {
        background: #eeeeee;
      }

      table tr:last-child td {
        background: #dddddd;
      }
    </style>
  </head>
  <body>
    <main>
      <h1 class="clearfix">
        <small>
          <span>Período</span>
          <br />
          {{ $period->format('F') }}, {{ $year }}
        </small>

        Suas Contas
      </h1>
      <table>
        <thead>
          <tr>
            <th class="desc">Descrição</th>
            <th>Parcela</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payments as $payment)
            <tr>
              <td class="desc">
                {{ $payment->getDebt()->getDescription() }}
              </td>
              <td class="qty">{{ $payment->getInstallment() }}/{{ $payment->getDebt()->getInstallments() }}</td>
              <td class="price">R$ {{ $payment->getPrice(true) }}</td>
            </tr>

            @php
                $total += $payment->getPrice();
            @endphp
          @endforeach
          <tr>
            <td colspan="2" class="grand total">TOTAL</td>
            <td class="grand total">R$ {{ number_format($total, 2, ',', '.') }}</td>
          </tr>
        </tbody>
      </table>
    </main>
  </body>
</html>
