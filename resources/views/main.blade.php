<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
       <style>
           td {
               text-align: center;
           }
       </style>
        <script>
            fetch('/file')
                .then(response => response.json())
                .then(data => {
                    createTable(data.rows)
                    console.log(data.prodCount);
                });



            function createTable(data) {
                // pobierz referencję do elementu tabeli HTML
                const table = document.querySelector('#my-table');

                // utwórz kod HTML nagłówków tabeli
                const headerRow = `<tr>
                <th>Lp</th>
                <th>nazwa producenta</th>
                <th>przekątna ekranu</th>
                <th>rozdzielczość ekranu</th>
                <th>rodzaj powierzchni ekranu</th>
                <th>czy ekran jest dotykowy</th>
                <th>nazwa procesora</th>
                <th>liczba rdzeni fizycznych</th>
                <th>prędkość taktowania MHz</th>
                <th>wielkość pamięci RAM</th>
                <th>pojemność dysku</th>
               <th> rodzaj dysku</th>
                <th>nazwa układu graficznego</th>
                <th>pamięć układu graficznego</th>
                <th>nazwa systemu operacyjnego</th>
                <th>rodzaj napędu fizycznego w komputerze</th>
</tr>`;

                // utwórz kod HTML wierszy tabeli na podstawie danych JSON

                const rows = data.map(item => {
                    let html = '';
                    Object.keys(item).forEach(key => {
                        html += `<td>${item[key]}</td>`;
                    });
                    return `<tr>${html}</tr>`;
                });


                const html = `<table>${headerRow}${rows.join('')}</table>`;
                table.innerHTML = html;
            }

        </script>
    </head>
    <body>

    <table id="my-table"></table>

    </body>
</html>
