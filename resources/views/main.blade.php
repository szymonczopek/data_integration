<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            body{
                font-family: monospace, sans-serif;
            }

            td{
                border-bottom: 2px solid black;
                border-right: 2px solid black;
                text-align: center;
            }
            th{
                font-weight: bold;
                border: 2px solid black;
                background: orange;
            }
            button{
                color: white;
                text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;
                border-top: black 2px solid;
                height: 40px;
                font-weight: bold;
                font-size: 0.8rem;
                margin: 5px;
            }
            .buttonDiv{
                display: flex;
            }
            .editButton{
                background: linear-gradient(to right, #ffb347, #ffcc33);
            }
            .deleteButton{
                background: #D23E1F;
                padding: 0 15px;
            }
            button:hover{
                opacity: 0.6;
            }
            td:hover{
                background: #DCDCDC;
            }
            #importCsvFile, #exportCsvFile{
                background: linear-gradient(to right, #00b09b, #96c93d);
            }
            #importXmlFile, #exportXmlFile{
                background: linear-gradient(to right, #667db6, #0082c8, #0082c8, #667db6);
            }
            #findRow{
                background: linear-gradient(to right, #800080, #ffc0cb);
            }
        </style>
    </head>
    <body>

    <button type="button" id="importCsvFile">Import z pliku CSV</button>
    <button type="button" id="exportCsvFile">Eksport do pliku CSV</button>
    <button type="button" id="importXmlFile">Import z pliku XML</button>
    <button type="button" id="exportXmlFile">Eksport do pliku XML</button>
    <button type="button" id="findRow">Znajdz rekod</button>

    <div id="error"></div>


    <table id="TableDiv">
        <thead id="tHead">

         </thead>
        <tbody id="TableBody">
        </tbody>
    </table>


    <div id="producents"></div>

    <script>
        const importCsvFile = document.getElementById("importCsvFile");
        const exportCsvFile = document.getElementById("exportCsvFile");
        const importXmlFile = document.getElementById("importXmlFile");
        const exportXmlFile = document.getElementById("exportXmlFile");

        const findRow = document.getElementById("findRow");
        const editButton = document.getElementById("editButton");
        const deleteButton = document.getElementById("deleteButton");

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
                case 10: return 'storage';
                case 11: return 'discType';
                case 12: return 'graphic_cardName';
                case 13: return 'memory';
                case 14: return 'os';
                case 15: return 'disc_reader';

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

        function displayTable(data, editable) {
            var rowCounter = 0;
            var columnCounter = 0;

            const headers = ["Lp.","Producent", "Wielkość ekranu", "Rozdzielczość", "Rodzaj ekranu", "Ekran dotykowy",
                "Procesor", "Liczba rdzeni procesora", "Częstotliwość procesora", "RAM", "Pojemność dysku",
                "Typ dysku", "Karta graficzna", "Pamięć karty graficznej", "System operacyjny",
                "Napęd optyczny"];

            const editButton = document.createElement('button');
            editButton.type = 'button';
            editButton.className = 'editButton';
            editButton.innerText = 'Wyslij do bazy danych';

            const deleteButton = document.createElement('button')
            deleteButton.type = 'button';
            deleteButton.className = 'deleteButton';
            deleteButton.innerText = 'X';

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
                if(editable === true) {
                    const buttonDiv = document.createElement('div');
                    buttonDiv.className = 'buttonDiv';
                    editButton.id = data[0][0];
                    buttonDiv.append(editButton);
                    buttonDiv.append(deleteButton);
                    newRow.append(buttonDiv);
                }
                TableBody.append(newRow);
                ++rowCounter;
            })

            editButton.addEventListener('click', async () => {
                console.log('taa')
                const row = isImported('laptop'+ editButton.id)

                body = {
                    'row': row
                };
                let isError = false;
                let message = '';

                await fetch('/laptop/edit/' + editButton.id, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    method: 'POST',
                    body: JSON.stringify(body),
                })
                    .then( async (response) => {
                        const responseData = await response.json();
                        message = responseData.message;
                        tekst = responseData.tekst;
                        console.log(tekst)
                        if (!response.ok) {
                            throw new Error(`${responseData.message}.`);
                        }

                    })

                    .catch( (error) => {
                        console.log(error)
                        isError = true;
                    });

                const newDiv = document.createElement('div')
                newDiv.textContent = message
                if (isError) {
                    newDiv.style.color = 'red';
                }
                TableDiv.after(newDiv);
            })

            let cellsCollection = TableDiv.getElementsByTagName('td')
            for(let i = 0; i < cellsCollection.length; i++) {
                cellsCollection[i].addEventListener('dblclick', (event) => {
                    let currentCell = event.target;
                    let editableCell = createEditableCell(currentCell);
                    editableCell.addEventListener('blur', () => {
                        let editedCell = editableCell.parentElement;
                        let currentValue = editableCell.value;
                        if(editable === true) {
                            updateVariable(editedCell, currentValue, editButton.id);
                        }
                        else {
                            updateVariable(editedCell, currentValue, null);
                        }
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
            tHeadDiv.innerHTML= '';
            tHeadDiv.appendChild(tableHeaderRow);
        }

        function updateVariable(cell, value, id) {
            const splittedId = cell.id.split('_');
            var row = parseInt(splittedId[0]);
            var column = parseInt(splittedId[1]);

            if(id !== null){
                row = id
                laptops[row][column] = value;
                sessionStorage.setItem('laptop'+id, JSON.stringify(laptops));

            }
            else{
                laptops[row][column] = value;
                sessionStorage.setItem('laptops', JSON.stringify(laptops));
            }
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

        function getRowId(findRow){
            const newInput = document.createElement('input');
            newInput.type = 'number';
            newInput.style.marginLeft = '50px';
            newInput.style.width = '70px';

            if(findRow.children.length === 0) {
                findRow.appendChild(newInput);
                newInput.focus();
                return 'clicked';
            }
            else{
                const rowId = findRow.querySelector('input');
                return rowId.value;
            }

        }

        function addRowButtons(){

        }

        importCsvFile.addEventListener('click', async () => {
                var isError = false;
                var message = '';
                await fetch('/importCsvFile', {
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

        exportCsvFile.addEventListener('click', async () => {
            console.log(JSON.stringify(laptops))
            body = {
                'rows': laptops
            };
            let isError = false;
            let message = '';

            await fetch('/exportCsvFile', {
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

        findRow.addEventListener('click', async () => {
            var isError = false;
            var message = '';

            const rowId = getRowId(findRow);
            if(rowId !== 'clicked' && rowId !== '') {


                 await fetch('/laptop/'+rowId, {
                     method: 'GET'
                 })
                     .then(async (response) => {
                         if (!response.ok) {
                             throw new Error('Nie znaleziono danych dla podanego ID '+ rowId);
                         }
                         return response.json();
                     })
                     .then(async (data) => {
                         if (data.error) {
                             const errorDiv = document.querySelector('#error');
                             const error = `<p>${data.error}</p>`
                             errorDiv.innerHTML = error;
                         }

                         const laptop = data.laptop
                         message = data.message;
                         sessionStorage.setItem('laptop'+rowId, JSON.stringify(laptop));
                         if (isImported('laptop'+rowId).length > 0) {
                             TableBody.innerHTML = '';
                         }
                         displayTable(laptop, true);

                     })
                     .catch( (error) => {
                         message = 'Brak wiersza dla podanego ID '+ rowId
                         console.error(error);
                         isError = true;
                     });

            }

            const newDiv = document.createElement('div')
            newDiv.textContent = message;
            if (isError) {
                newDiv.style.color = 'red';
            }
            TableDiv.after(newDiv);

        })

    </script>
    </body>
</html>
