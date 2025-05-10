<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        /* Inline styles for simplicity, consider using CSS classes for larger templates */
    </style>
</head>

<body>
<div class="container">

    <table>
        <thead>
            <th>Name</th>
            <th>Value</th>
        </thead>
        <tbody>
            @foreach($data as $name => $value)
                @continue(str_ends_with($name, '_'))
                <tr>
                    <td>{{str_replace('_', ' ', $name)}}</td>
                    <td>{{$value}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
</body>

</html>