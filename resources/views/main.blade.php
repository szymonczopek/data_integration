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

    <button type="button" id="importFile">Import z pliku</button>
    <button type="button" id="exportFile">Eksport do pliku</button>

    <div id="error"></div>


    <table id="TableDiv">
        <thead>
        <tr>
            @foreach($header as $hd)
                <th>{{ $hd }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody id="TableBody">
        </tbody>
    </table>


    <div id="producents"></div>

    <script>
        const importFile = document.getElementById("importFile");
        const exportFile = document.getElementById("exportFile");
        const TableDiv = document.getElementById("TableDiv");
        const TableBody = document.getElementById("TableBody");



        const touchscreen = ['tak', 'nie'];
        const processors = ['intel pentium', 'intel celeron', 'intel i3', 'intel i5', 'intel i7', 'intel i9',
            'amd ryzen 3', 'amd ryzen 5', 'amd ryzen 7', 'amd ryzen 9', 'amd ryzen threadripper'];
        const cores = ['2', '4', '6', '8', '10', '12', '14', '16', '18', '24', '32', '64'];
        const disks = ['HDD', 'SSD'];
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
                case 4: return 'matrixType';
                case 5: return 'touchscreen';
                case 6: return 'processor';
                case 7: return 'cores';
                case 8: return 'clockSpeed';
                case 9: return 'ram';
                case 10: return 'discCapacity';
                case 11: return 'disks';
                case 12: return 'graphicsCard';
                case 13: return 'graphicsCardMemory';
                case 14: return 'operatingSystem';
                case 15: return 'drives';
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
                    editableField = createInput(cell, 'text', true,{minlength: '2', maxlength: '10'});
                    break
                case 'size':
                    editableField = createSelect(cell, size, true);
                    break
                case 'resolution':
                    editableField = createInput(cell, 'text', true);
                    break
                case 'matrixType':
                    editableField = createSelect(cell, matrixTypes, true);
                    break
                case 'touchscreen':
                    editableField = createSelect(cell, touchscreen, true);
                    break
                case 'processor':
                    editableField = createSelect(cell, processors, true);
                    break
                case 'cores':
                    editableField = createSelect(cell, cores, true);
                    break
                case 'clockSpeed':
                    editableField = createInput(cell, 'text', true);
                    break
                case 'ram':
                    editableField = createInput(cell, 'text', true);
                    break
                case 'discCapacity':
                    editableField = createInput(cell, 'text', true);
                    break
                case 'disks':
                    editableField = createSelect(cell, disks, true);
                    break
                case 'graphicsCard':
                    editableField = createInput(cell, 'text', true);
                    break
                case 'graphicsCardMemory':
                    editableField = createInput(cell, 'text', true);
                    break
                case 'operatingSystem':
                    editableField = createInput(cell, 'text', true);
                    break
                case 'drives':
                    editableField = createSelect(cell, drives, true);
                    break
            }
            return editableField;
        }

        function displayTable(data) {
            var rowCounter = 0;
            var columnCounter = 0;

            data.forEach((row) => {
                const newRow = document.createElement('tr');
                newRow.setAttribute('id', 'row_' + rowCounter);
                columnCounter = 0;
                row.forEach((cell) => {
                    const newCell = document.createElement('td');
                    newCell.classList.add(getClassNameByColumn(columnCounter));
                    newCell.setAttribute('id', 'field_' + rowCounter + '_' + columnCounter);
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
                        updateVariable(editedCell, currentValue);
                        currentCell.removeChild(editableCell);
                        editedCell.textContent = currentValue;
                    })
                    editableCell.addEventListener('keypress', (event) => {
                        if (event.key === 'Enter') {
                            event.preventDefault();

                            const editedCell = editableCell.parentElement;

                            if (isValidInput(editableCell)) {
                                editedCell.removeChild(editedCell.lastChild);
                                editedCell.style.removeProperty('border');

                                editableCell.blur();
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

        function updateVariable(cell, value) {
            const splittedId = cell.id.split('_');
            const row = parseInt(splittedId[1]);
            const column = parseInt(splittedId[2]);
            laptops[row][column] = value;
            sessionStorage.setItem('laptops', JSON.stringify(laptops));
        }

        function validateInput(input) {
            let errors = [];

            switch (input.tagName.toLowerCase()) {
                case 'input': {
                    if (input.value === "") {
                        errors.push('This field is required.');
                    }
                      if (input.value.length < input.getAttribute('minlength')) {
                        errors.push('This field should contain at least ' + input.getAttribute('minlength') + ' characters.');
                      }
                      if (input.value.length > input.getAttribute('maxlength')) {
                        errors.push('This field should contain at most ' + input.getAttribute('maxlength') + ' characters.');
                      }
                       if (input.value.length < input.getAttribute('minlength') && input.value.length > input.getAttribute('maxlength')) {
                         errors.push('This field should contain between ' + input.getAttribute('minlength') + 'and' + input.getAttribute('maxlength') + ' characters.');
                       }
                    //   const regex = input.getAttribute('pattern')
                    //   if (!regex.test(input.value)) {
                    //     errors.push('This field should match the given pattern: ' + regex)
                    //   }
                    break;
                }
                case 'select': {
                    if (input.value === "") {
                        errors.push('This field is required.')
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

        window.addEventListener('load', () => {
            displayTable(laptops)
        })

            importFile.addEventListener('click', async () => {
                var isError = false;
                var message = '';
                await fetch('/importFile', {
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
                        sessionStorage.setItem('laptops', JSON.stringify(laptops))
                        if (isImported('laptops').length > 0) {
                            TableBody.innerHTML = '';
                        }
                        displayTable(laptops);
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

        exportFile.addEventListener('click', async () => {
            bodyy = {
                'laptops': laptops
            };
            let isError = false;
            let message = '';
            const endpoint = '/exportFile';

            await fetch(endpoint, {
                method: "POST",
                body: JSON.stringify(bodyy),
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then( async (response) => {
                    const responseData = await response.json()
                    message = responseData.message
                    if (!response.ok) {
                        throw new Error(`${responseData.message}.`)
                    }
                    console.log(responseData)
                })
                .catch( (error) => {
                    // console.log(error)
                    isError = true
                });

            const newDiv = document.createElement('div')
            newDiv.textContent = message
            if (isError) {
                newDiv.style.color = 'red'
            }
            TableDiv.after(newDiv)

        })

    </script>
    </body>
</html>
