<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musketeers Idea Ltd.-balance-sheet-summary</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 
</head>
<body>

    {{-- @php
    dd($chartAccounts);
    @endphp --}}


  
<div class="container-fluid text-center">    
<div id="printableArea">
    <div class="row mt-4">
        <div class="col">
            <input type="hidden" value="{{__('Balance Sheet').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
            <div class="card p-4 mb-4">
                <h6 class="report-text gray-text mb-0">{{__('Report')}} :Musketeers Idea Ltd.</h6>
                <h5>{{__('Balance Sheet-Summary')}}</h5>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>Acc Head id</th>
            <th>G. Lvl 1 </th>
            <th>G. Lvl 2</th>
            <th>Acc Head </th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
           

            @foreach($chartAccounts as $type => $accounts)
                @foreach($accounts as $account)
                    @foreach($account['account'] as  $key =>$record)
                    <tr style="text-align: left;">
                        <td>{{$record['id']}}</td>
                        <td>{{$record['level_name']}}</td>
                        <td>{{$account['subType']}}</td>
                        <td>{{$record['account_name']}}</td>
                        <td>{{($record['netAmount'])}}</td>
                        </tr>
                    </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
      </table>
    </div>
</div>
</body>
</html>
