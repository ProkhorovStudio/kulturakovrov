<?

include_once(__DIR__.'/crest.php');
ini_set('display_errors', 'On');
error_reporting(E_ALL);?>


<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/app.css">
    <!--link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"-->
    <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>

    <style>
        .box {
            background-size: cover;
            background-image: url('back.jpg');
        }
        .background-tint {
            background-color: rgba(255,255,255,.8);
            background-blend-mode: screen;
        }
    </style>

    <title>Index</title>
</head>
<?

$result = CRest::call(
    'crm.contact.list',
    [
        'FILTER' => [
            'PHONE' => '+79060334663',
        ],
        'SELECT' => [
            'ID',
            'NAME',
            'LAST_NAME'
        ]
    ]
);
echo "<pre>";
print_r($result);
echo "</pre>";
?>
<body class="container-fluid box background-tint">
<div class="center-block">
    
  Дефолтная страница
</div>
</body>
</html>