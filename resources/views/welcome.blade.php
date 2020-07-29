<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: black;
            color: blanchedalmond;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .alert {
            padding: 20px;
            background-color: #f44336;
            /* Red */
            color: white;
            margin-bottom: 15px;
        }

        .success {
            padding: 20px;
            background-color: chartreuse;
            /* Red */
            color: white;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            @if(session()->has('error'))
            <div class="alert">
                {{ session()->get('error') }}
            </div>
            @endif
            @if(session()->has('success'))
            <div class="success">
                {{ session()->get('success') }}
            </div>
            @endif
            <h2>Import Excel File into Part Shortage</h2>
            <div class="outer-container">
                <form action="{{route('importVendor')}}" method="post" name="frmExcelImport" id="frmExcelImport"
                    enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label>Choose Excel
                            File</label> <input type="file" name="file" id="file" accept=".xls,.xlsx">
                        <button type="submit" id="submit" name="import" class="btn-submit">Import</button>
                    </div>
                </form>
            </div>
            @if(session()->has('result'))
            {{-- <h2>datas</h2> --}}
            <table>
                <thead>
                    <th>#</th>
                    <th>MAT_CODE</th>
                    <th>PLANT_CODE</th>
                    <th>VENDOR_ID</th>
                    <th>VENDOR_NAME</th>
                </thead>
                <tbody>
                    @foreach (session()->get('result') as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->MAT_CODE}}</td>
                        <td>{{$item->PLANT_CODE}}</td>
                        <td>{{$item->VENDOR_ID}}</td>
                        <td>{{$item->VENDOR_NAME}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</body>

</html>