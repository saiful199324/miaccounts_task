<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musketeers Idea Ltd.-balance-sheet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container-fluid text-center">    
<div id="printableArea">
        <div class="row mt-4">
            <div class="col">
                <input type="hidden" value="{{__('Balance Sheet').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h6 class="report-text gray-text mb-0">{{__('Report')}} :Musketeers Idea Ltd.</h6>
                    <h5 class="report-text mb-0">{{__('Balance Sheet')}}</h5>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($chartAccounts as $type => $accounts)
                @php $totalNetAmount=0; @endphp

                @foreach($accounts as  $accountData)
                    @foreach($accountData['account'] as  $account)
                        @php $totalNetAmount+=$account['netAmount']; @endphp
                    @endforeach
                @endforeach
               
            @endforeach
        </div>
        

        <div class="row mb-4">
            @foreach($chartAccounts as $type => $accounts)
                <div class="col-lg-12 mb-4">
                    <h5 style="text-align: left !important;"><span style="margin-left: 20px;">{{$type}}</span></h5>
                    <div class="row">
                        @foreach($accounts as $account)
                            <div class="col-lg-12 col-md-12 mb-12">
                                <div class="card card-fluid">
                                    <table class="table table-flush">
                                        <thead>
                                        <tr>
                                        {{-- <th class="text-muted">{{$type}}</th> --}}
                                        </tr>
                                        </thead>
                                        <tbody class="balance-sheet-body">
                                        @php $totalCredit=0;$totalDebit=0;@endphp
                                        
                                        
                                        <tr>
                                             @foreach($account['account'] as  $record)
                                                @php
                                                    $totalCredit+=$record['totalCredit'];
                                                    $totalDebit+=$record['totalDebit'];
                                                @endphp
                                                <tr style="display: none;">
                                                    <td style="text-align: left;"><span style="margin-left: 50px;">{{$record['account_name']}}</span></td>
                                                    <td style="text-align: left;">
                                                        @if($record['netAmount']>0)
                                                            {{($record['netAmount'])}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <th><span style="margin-left: 20px;">{{$account['subType']}}</span></th>
                                            <th>
                                                @php $total= $totalCredit-$totalDebit; @endphp
                                                @if($total>0)
                                                {{$total}}
                                                @endif
                                            </th>
                                        </tr>
                                        </tbody>
                                        <thead>
                                        @foreach($account['account'] as  $record)
                                            @php
                                                $totalCredit+=$record['totalCredit'];
                                                $totalDebit+=$record['totalDebit'];
                                            @endphp
                                            <tr>
                                                <td style="text-align: left;"><span style="margin-left: 50px;">{{$record['account_name']}}</span></td>
                                                <td style="text-align: left;">
                                                    @if($record['netAmount']>0)
                                                        {{($record['netAmount'])}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>
