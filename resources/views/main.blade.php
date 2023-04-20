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


        <style>
            body{
                font-family: monospace, sans-serif;
            }
            td{
                border-bottom: 2px solid black;
                border-right: 2px solid black;
            }
            th{
                border-bottom: 2px solid black;
                border-top: 2px solid black;
                background: orange;
            }
        </style>
    </head>
    <body>

    <button type="button" id="importTxtFile">Import z pliku txt</button>
    <button type="button" id="exportTxtFile">Eksport do pliku txt</button>
    <button type="button" id="importXmlFile">Import z pliku xml</button>
    <button type="button" id="exportXmlFile">Eksport do pliku xml</button>

    <div id="error"></div>


    <table id="TableDiv">
        <thead id="tHead">
         {{--<tr>
             @foreach($header as $hd)
                 <th>{{ $hd }}</th>
             @endforeach
         </tr>--}}
         </thead>
        <tbody id="TableBody">
        </tbody>
    </table>


    <div id="producents"></div>

    <script>
        const importTxtFile = document.getElementById("importTxtFile");
        const exportTxtFile = document.getElementById("exportTxtFile");
        const importXmlFile = document.getElementById("importXmlFile");
        const exportXmlFile = document.getElementById("exportXmlFile");
        const TableDiv = document.getElementById("TableDiv");
        const TableBody = document.getElementById("TableBody");

        const touchscreen = ['tak', 'nie','yes','no'];
        const processors = ['intel pentium', 'intel celeron', 'intel i3', 'intel i5', 'intel i7', 'intel i9',
            'amd ryzen 3', 'amd ryzen 5', 'amd ryzen 7', 'amd ryzen 9', 'amd ryzen threadripper'];
        const cores = ['2', '4', '6', '8', '10', '12', '14', '16', '18', '24', '32', '64'];
        const discs = ['HDD', 'SSD'];
        const matrixTypes = ['matowa', 'blyszczaca'];
        const drives = ['brak', 'DVD', 'Blu-Ray'];
        const size = ['10,5"', '11,6"', '12,4"', '13"', '13,3"', '13,4"', '13,5"', '13,6"',
            '14"', '14,1"', '14,2"', '14,4"', '14,5"', '15"', '15,6"', '16"', '16,1"', '16,2"',
            '17"', '17,3"', '18"'];

        var laptops = isImported('laptops');

        function isImported(item) {
            if (sessionStorage.getItem(item) !== null) {
                return JSON.parse(sessionStorage.getItem(item));
            }
            return [];
        }
        function getClassNameByColumn(colNumber) {
            switch (colNumber) {

                case 0: return 'counter';
                case 1: return 'manufacturer';
                case 2: return 'size';
                case 3: return 'resolution';
                case 4: return 'screenType';
                case 5: return 'touch';
                case 6: return 'processorName';
                case 7: return 'physical_cores';
                case 8: return 'clockSpeed';
                case 9: return 'ram';
                case 10: return 'discType';
                case 11: return 'storage';
                case 12: return 'graphic_cardName';
                case 13: return 'memory';
                case 14: return 'os';
                case 15: return 'disc_reader';

                case 'id': return 'counter';
                case 'manufacturer': return 'manufacturer';
                case 'size': return 'size';
                case 'resolution': return 'resolution';
                case 'screenType': return 'screenType';
                case 'touch': return 'touch';
                case 'processorName': return 'processorName';
                case 'physical_cores': return 'physical_cores';
                case 'clock_speed': return 'clockSpeed';
                case 'ram': return 'ram';
                case 'discType': return 'discType';
                case 'storage': return 'storage';
                case 'graphic_cardName': return 'graphic_cardName';
                case 'memory': return 'memory';
                case 'os': return 'os';
                case 'disc_reader': return 'disc_reader';
            }
        }
        function createInput(currentElement, type, isRequired = false, otherAttributes = {}) {
            const newInput = document.createElement('input');
            newInput.type = type;
            newInput.id = currentElement.id;
            newInput.name = currentElement.className;
            newInput.required = isRequired;
            newInput.setAttribute('value', currentElement.textContent);
            if (Object.keys(otherAttributes).length !== 0) {
                Object.keys(otherAttributes).forEach((key) => {
                    switch (key) {
                        case 'pattern':
                            newInput.setAttribute('pattern', otherAttributes.pattern);
                            break;
                        case 'minlength':
                            newInput.setAttribute('minlength', otherAttributes.minlength);
                            break;
                        case 'maxlength':
                            newInput.setAttribute('maxlength', otherAttributes.maxlength);
                            break;
                    }
                })
            }
            newInput.style.width = '100%';
            newInput.style.height = '100%';
            newInput.style.border = '0px';
            newInput.style.fontFamily = 'inherit';
            newInput.style.fontSize = 'inherit';
            newInput.style.textAlign = 'inherit';
            return newInput;
        }

        function createSelect(currentElement, options, isRequired = false) {
            const newSelect = document.createElement('select');
            newSelect.id = currentElement.id;
            newSelect.name = currentElement.className;
            newSelect.required = isRequired;
            for (const opt of options) {
                const newOption = document.createElement('option');
                newOption.value = opt;
                newOption.textContent = opt;
                if (currentElement.textContent === opt) {
                    newOption.selected = 'selected';
                }
                newSelect.appendChild(newOption);
            }
            newSelect.style.width = '100%';
            newSelect.style.height = '100%';
            newSelect.style.border = '0px';
            newSelect.style.fontFamily = 'inherit';
            newSelect.style.fontSize = 'inherit';
            newSelect.style.textAlign = 'inherit';
            return newSelect
        }

        function createEditableCell(cell) {
            let editableField
            switch (cell.className) {
                case 'manufacturer':
                    // editableField = createInput(currentCell, 'text', true, {minlength: '2', maxlength: '10'})
                    editableField = createInput(cell, 'text', true,{minlength: 2, maxlength: 16});
                    break
                case 'size':
                    editableField = createSelect(cell, size, true);
                    break
                case 'resolution':
                    editableField = createInput(cell, 'text', true,{pattern: '^[0-9]{3,4}x[0-9]{3,4}$' });
                    break
                case 'screenType':
                    editableField = createSelect(cell, matrixTypes, true);
                    break
                case 'touch':
                    editableField = createSelect(cell, touchscreen, true);
                    break
                case 'processorName':
                    editableField = createSelect(cell, processors, true);
                    break
                case 'physical_cores':
                    editableField = createSelect(cell, cores, true);
                    break
                case 'clockSpeed':
                    editableField = createInput(cell, 'text', true,{pattern: '^[0-9]{1,}$' });
                    break
                case 'ram':
                    editableField = createInput(cell, 'text', true,{pattern: '^[0-9]{1,}GB$' });

                    break
                case 'storage':
                    editableField = createInput(cell, 'text', true,{pattern: '^[0-9]{3,}GB$' });
                    break
                case 'discType':
                    editableField = createSelect(cell, discs, true);
                    break
                case 'graphic_cardName':
                    editableField = createInput(cell, 'text', true,{minlength: 2, maxlength: 32});
                    break
                case 'memory':
                    editableField = createInput(cell, 'text', true,{pattern: '^[0-9]{1,}GB$' });
                    break
                case 'os':
                    editableField = createInput(cell, 'text', true,{pattern: '^[0-9]{1,}GB$' });
                    break
                case 'disc_reader':
                    editableField = createSelect(cell, drives, true);
                    break
            }
            return editableField;
        }

        function displayTxtTable(data) {
            var rowCounter = 0;
            var columnCounter = 0;

            const headers = ["Lp.","Producent", "Wielkość ekranu", "Rozdzielczość", "Rodzaj ekranu", "Ekran dotykowy",
                "Procesor", "Liczba rdzeni procesora", "Częstotliwość procesora", "RAM", "Pojemność dysku",
                "Typ dysku", "Karta graficzna", "Pamięć karty graficznej", "System operacyjny",
                "Napęd optyczny"];

            displayHeader(headers);

            data.forEach((row) => {
                const newRow = document.createElement('tr');
                newRow.setAttribute('id', 'row_' + rowCounter);
                columnCounter = 0;

                row.forEach((cell) => {
                   const newCell = document.createElement('td');
                    newCell.classList.add(getClassNameByColumn(columnCounter));
                    newCell.setAttribute('id', rowCounter + '_' + columnCounter);
                    newCell.textContent = cell;
                    newRow.appendChild(newCell);
                    ++columnCounter;

                })

                TableBody.append(newRow);
                ++rowCounter;
            })

            let cellsCollection = TableDiv.getElementsByTagName('td')
            for(let i = 0; i < cellsCollection.length; i++) {
                cellsCollection[i].addEventListener('dblclick', (event) => {
                    let currentCell = event.target;
                    let editableCell = createEditableCell(currentCell);
                    editableCell.addEventListener('blur', () => {
                        let editedCell = editableCell.parentElement;
                        let currentValue = editableCell.value;
                        updateVariable(editedCell, currentValue,'txt');
                        currentCell.removeChild(editableCell);
                        editedCell.textContent = currentValue;
                    })
                    editableCell.addEventListener('keypress', (event) => {
                        if (event.key === 'Enter') {
                            event.preventDefault();

                            const editedCell = editableCell.parentElement;

                            if (isValidInput(editableCell)) {
                                if(editedCell.lastChild !== null) {
                                    editedCell.removeChild(editedCell.lastChild);
                                    editedCell.style.removeProperty('border');
                                    editableCell.blur();
                                }
                            } else {
                                let errors = validateInput(editableCell)
                                let errorsText = '';
                                errors.forEach((error) => {
                                    errorsText += error + "\n";
                                })

                                const newSpan = document.createElement('span');
                                newSpan.textContent = errorsText;
                                editableCell.after(newSpan);
                                editedCell.style.border = '5px solid rgb(200, 0, 0)';
                            }
                        }
                    })
                    currentCell.textContent = ''
                    currentCell.appendChild(editableCell);
                    if (currentCell.firstChild.tagName.toLowerCase() === 'input'){
                        currentCell.firstChild.select();
                    }
                })
            }

        }
        function displayXmlTable(data) {
            var rowCounter = 0;
            var columnCounter = 0;

            const headers = ["Lp.","Producent", "Ekran dotykowy", "Wielkość ekranu", "Rozdzielczosc", "Rodzaj ekranu",
                "Procesor", "Liczba rdzeni procesora", "Częstotliwość procesora", "RAM",
                "Typ dysku","Pojemność dysku", "Karta graficzna", "Pamięć karty graficznej", "System operacyjny",
                "Napęd optyczny"];

            displayHeader(headers);

            for (const item of data) { // I
                const newRow = document.createElement('tr');
                newRow.setAttribute('id', 'row_' + rowCounter);
                columnCounter = 0;

                for (const prop in item) { // II
                    if (typeof item[prop] === 'object' && !Array.isArray(item[prop])) { // jesli obiekt, jesli istnieje 3 wymiar
                        for (const obj in (item[prop])) { // III
                            //  console.log(obj+':'+item[prop][obj]);
                            const newCell = document.createElement('td');
                            newCell.classList.add(getClassNameByColumn(obj));
                            newCell.setAttribute('id',rowCounter + '_' + columnCounter);
                            newCell.textContent = item[prop][obj];
                            newRow.appendChild(newCell);
                            ++columnCounter;
                            }
                        }
                    else { //jesli wartosc
                       // console.log(prop+':'+item[prop])
                        const newCell = document.createElement('td');
                        newCell.classList.add(getClassNameByColumn(prop))
                        newCell.setAttribute('id',rowCounter + '_' + columnCounter);
                        newCell.textContent = item[prop];
                        newRow.appendChild(newCell);
                        ++columnCounter;
                    }

                }
                TableBody.append(newRow);
                ++rowCounter;
            }
            let cellsCollection = TableDiv.getElementsByTagName('td')
            for(let i = 0; i < cellsCollection.length; i++) {
                cellsCollection[i].addEventListener('dblclick', (event) => {
                    let currentCell = event.target;
                    let editableCell = createEditableCell(currentCell);
                    editableCell.addEventListener('blur', () => {
                        let editedCell = editableCell.parentElement;
                        let currentValue = editableCell.value;
                        updateVariable(editedCell, currentValue,'xml');
                        currentCell.removeChild(editableCell);
                        editedCell.textContent = currentValue;
                    })
                    editableCell.addEventListener('keypress', (event) => {
                        if (event.key === 'Enter') {
                            event.preventDefault();

                            const editedCell = editableCell.parentElement;

                            if (isValidInput(editableCell)) {
                                if(editedCell.lastChild !== null) {
                                    editedCell.removeChild(editedCell.lastChild);
                                    editedCell.style.removeProperty('border');
                                    editableCell.blur();
                                }
                            } else {
                                let errors = validateInput(editableCell)
                                let errorsText = '';
                                errors.forEach((error) => {
                                    errorsText += error + "\n";
                                })

                                const newSpan = document.createElement('span');
                                newSpan.textContent = errorsText;
                                editableCell.after(newSpan);
                                editedCell.style.border = '5px solid rgb(200, 0, 0)';
                            }
                        }
                    })
                    currentCell.textContent = ''
                    currentCell.appendChild(editableCell);
                    if (currentCell.firstChild.tagName.toLowerCase() === 'input'){
                        currentCell.firstChild.select();
                    }
                })
            }

        }
        function displayHeader(headers){
            var tHeadDiv = document.getElementById("tHead");
            const tableHeaderRow = document.createElement('tr');

            headers.forEach((element)=>{
                const label = document.createElement('th');
                label.textContent = element;
                tableHeaderRow.appendChild(label);
            })
            //const tableHeaderLabels = document.createElement('thead');
            //tableHeaderLabels.appendChild(tableHeaderRow);
            tHeadDiv.innerHTML= '';
            tHeadDiv.appendChild(tableHeaderRow);
        }

        function updateVariable(cell, value, fileType) {
            const splittedId = cell.id.split('_');
            const row = parseInt(splittedId[0]);
            var column;
            switch(fileType) {
                case 'txt':{
                    column = parseInt(splittedId[1]);
                    laptops[row][column] = value;
                } break;
                case 'xml': {
                    column = cell.className;
                    var item = laptops[row]
                        for (const prop in item) { // II
                            if (typeof item[prop] === 'object' && !Array.isArray(item[prop])) { // jesli obiekt
                                for (const obj in (item[prop])) { // III
                                    //  console.log(obj+':'+item[prop][obj]);
                                    if (obj === column) {
                                        //item[prop][obj] = value;
                                        item[prop][obj] = value;
                                    }
                                }
                            }
                            if (prop === column) item[prop] = value;
                        }
                } break;
                    return laptops
            }
            sessionStorage.setItem('laptops', JSON.stringify(laptops));
        }
        function validateInput(input) {
            let errors = [];

            switch (input.tagName.toLowerCase()) {
                case 'input': {
                    if (input.value === "") {
                        errors.push('Pole nie moze być puste.');
                    }
                    if (input.getAttribute('minlength') && input.value.length < input.getAttribute('minlength')) {
                        if(input.getAttribute('minlength') > 4) errors.push('To pole powinno zawierac przynajmniej ' + input.getAttribute('minlength') + ' znakow.');
                        else errors.push('To pole powinno zawierac przynajmniej ' + input.getAttribute('minlength') + ' znaki.');

                      }
                      if (input.getAttribute('maxlength') && input.value.length > input.getAttribute('maxlength')) {
                        errors.push('To pole powinno zawierac maksymalnie ' + input.getAttribute('maxlength') + ' znakow.');
                      }
                       if (input.getAttribute('minlength') && input.getAttribute('maxlength') && input.value.length < input.getAttribute('minlength') && input.value.length > input.getAttribute('maxlength')) {
                         errors.push('To pole powinno zawierac pomiedzy ' + input.getAttribute('minlength') + 'a' + input.getAttribute('maxlength') + ' znakow.');
                       }
                       if(input.getAttribute('pattern') !== null && input.value !== "") {
                           var regexp = input.getAttribute('pattern')
                           regexp = new RegExp(regexp)
                           if (!regexp.test(input.value)) {
                               errors.push('Niepoprawna forma zapisu.')
                           }
                       }
                }break;
                case 'select': {
                    if (input.value === "") {
                        errors.push('To pole jest wymagane.')
                    }
                    break;
                }
            }

            return errors
        }

        function isValidInput(input) {
            let errors = validateInput(input)
            if (errors.length > 0) {
                return false;
            }
            return true
        }
        function displayProducents(prodNames, prodCount){
            const producents = document.querySelector('#producents');
            var html = ``;

            for (let i = 0; i < prodNames.length; i++) {
                html += `Liczba egzemplarzy firmy ${prodNames[i]} : ${prodCount[i]}</br>`;
            }
            producents.innerHTML = html;
        }

        /*window.addEventListener('load', () => {
            displayTable(laptops);
        })*/

            importTxtFile.addEventListener('click', async () => {
                var isError = false;
                var message = '';
                await fetch('/importTxtFile', {
                    method: 'GET'
                })
                    .then(async (response) => await response.json())
                    .then(async (data) => {
                        if (data.error) {
                            const errorDiv = document.querySelector('#error');
                            const error = `<p>${data.error}</p>`
                            errorDiv.innerHTML = error;
                        }
                        laptops = data.rows;
                        message = data.message;
                        sessionStorage.setItem('laptops', JSON.stringify(laptops));
                        if (isImported('laptops').length > 0) {
                            TableBody.innerHTML = '';
                        }
                        displayTxtTable(laptops);
                    })
                    .catch( (error) => {
                        // console.log(error)
                        isError = true;
                    });

                const newDiv = document.createElement('div')
                newDiv.textContent = message;
                if (isError) {
                    newDiv.style.color = 'red';
                }
                TableDiv.after(newDiv);



            });

        exportTxtFile.addEventListener('click', async () => {
            //console.log(JSON.stringify(laptops))
            body = {
                'rows': laptops
            };
            let isError = false;
            let message = '';

            await fetch('/exportTxtFile', {
                headers: {
                    'Content-Type': 'application/json',
                },
                method: 'POST',
                body: JSON.stringify(body),
            })
                .then( async (response) => {
                    const responseData = await response.json();
                    message = responseData.message;
                    if (!response.ok) {
                        throw new Error(`${responseData.message}.`);
                    }

                })

                .catch( (error) => {
                    // console.log(error)
                    isError = true;
                });

            const newDiv = document.createElement('div')
            newDiv.textContent = message
            if (isError) {
                newDiv.style.color = 'red';
            }
            TableDiv.after(newDiv);

        })

        importXmlFile.addEventListener('click', async () => {
            var isError = false;
            var message = '';
            await fetch('/importXmlFile', {
                method: 'GET'
            })
                .then(async (response) => await response.json())
                .then(async (data) => {
                    if (data.error) {
                        const errorDiv = document.querySelector('#error');
                        const error = `<p>${data.error}</p>`
                        errorDiv.innerHTML = error;
                    }
                    laptops = data.rows;
                    message = data.message;
                    sessionStorage.setItem('laptops', JSON.stringify(laptops));
                    if (isImported('laptops').length > 0) {
                        TableBody.innerHTML = '';
                    }
                    displayXmlTable(laptops);
                })
                .catch( (error) => {
                    // console.log(error)
                    isError = true;
                });



            const newDiv = document.createElement('div')
            newDiv.textContent = message;
            if (isError) {
                newDiv.style.color = 'red';
            }
            TableDiv.after(newDiv);



        });
        exportXmlFile.addEventListener('click', async () => {


            body = {
                'rows': laptops
            };
            let isError = false;
            let message = '';

            await fetch('/exportXmlFile', {
                headers: {
                    'Content-Type': 'application/json',
                },
                method: 'POST',
                body: JSON.stringify(body),
            })
                .then( async (response) => {
                    const responseData = await response.json();
                    message = responseData.message;
                    if (!response.ok) {
                        throw new Error(`${responseData.message}.`);
                    }

                })
                .catch( (error) => {
                    // console.log(error)
                    isError = true;
                });

            const newDiv = document.createElement('div')
            newDiv.textContent = message
            if (isError) {
                newDiv.style.color = 'red';
            }
            TableDiv.after(newDiv);

        })

    </script>
    </body>
</html>
