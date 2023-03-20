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
                    if(data.error){
                        const errorDiv = document.querySelector('#error');
                        const error = `<p>${data.error}</p>`
                        errorDiv.innerHTML = error;
                    }
                    displayTable(data.rows);
                    displayProducents(data.prodNames,data.prodCount);
                    editTable();
                });

            function editTable(){
                const table = document.querySelector('#my-table');
                var td = table.getElementsByTagName('td');

                for (var i=0; i < td.length; i++){
                   td[i].onclick = function(){
                   var input = document.createElement('input');
                    input.setAttribute('type','text');
                    input.value = this.innerHTML;
                       //input.style.width = this.offsetWidth;
                    input.style.height = this.offsetHeight + "px";
                    input.style.border = "0px";
                    input.style.textAlign = "inherit"
                       input.style.backgroundColor = '#a6a6a6'


                    this.innerHTML= '';
                    this.style.cssText = 'padding: 0 0';
                    this.append(input);
                    this.firstElementChild.select();

                    }
                }
            }



            function displayTable(data) {
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


                const html = `<table">${headerRow}${rows.join('')}</table>`;
                table.innerHTML = html;
            }

            function displayProducents(prodNames, prodCount){
                const producents = document.querySelector('#producents');
                var html = ``;

                for (let i = 0; i < prodNames.length; i++) {
                    html += `Liczba egzemplarzy firmy ${prodNames[i]} : ${prodCount[i]}</br>`;
                }
                producents.innerHTML = html;
            }

        </script>
    </head>
    <body>

    <div id="error"></div>

    <table id="my-table"></table>

    <div id="producents"></div>
    </body>
</html>
