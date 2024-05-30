async function initMap() {

    const map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 52.093752, lng: 23.740995},
        zoom: 12
    });
    const image = "https://www.google.by/maps/vt/icon/name=assets/icons/transit/quantum_v2/bus-0-tiny.png&scale=2"

    fetch('http://localhost:8876/api/bus-stops', {
        method: 'GET'
    }).then(response => response.json())
        .then(stopsData => {
            console.log(stopsData);
            stopsData.forEach(markerData => {
                const marker = new google.maps.Marker({
                    position: markerData.position,
                    map: map,
                    title: markerData.title,
                    icon: image
                });
                const infoWindow = new google.maps.InfoWindow({
                    content: '<div><strong>Текущая: ' + markerData.title + '</strong>' +
                        '<br><strong>Следующая: ' + markerData.next + '</strong>' +
                        '<br><label for="fullName">ФИО:</label><br><input type="text" id="fullName">' +
                        '<br><label for="phoneNumber">Номер телефона:</label><br><input type="text" id="phoneNumber">' +
                        '<br><label for="email">Логин:</label><br><input type="text" id="email">' +
                        '<br><label for="password">Пароль:</label><br><input type="text" id="password">' +
                        `<br><br><button onclick="saveData('${markerData.id}')">Сохранить</button></div>` +
                        `<br><button onclick="showData('${markerData.id}')">Просмотр</button></div>`
                });
                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    var menuDiv = document.createElement('div');
    var menu = new CustomMenu(menuDiv, map);

    menuDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(menuDiv);

}

function saveData(id) {
    const fullName = document.getElementById('fullName').value;
    const phoneNumber = document.getElementById('phoneNumber').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    fetch(`http://localhost:8876/api/users/`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            bus_stop_id: id,
            full_name: fullName,
            phone_number: phoneNumber,
            email: email,
            password: password
        })
    })
        .then(response => {
            console.log(response)
            response.text()
        })
        .then(data => {
            console.log(data)
        }).catch(error => console.error('Error saving data:', error));
}

function CustomMenu(controlDiv, map) {
    var exportButton = document.createElement('button');
    exportButton.innerHTML = 'Экспортировать в CSV';
    controlDiv.appendChild(exportButton);

    var importButton = document.createElement('button');
    importButton.innerHTML = 'Импортировать из CSV';
    controlDiv.appendChild(importButton);

    var infoButton = document.createElement('button');
    infoButton.innerHTML = 'Инструкции';
    controlDiv.appendChild(infoButton);

    exportButton.addEventListener('click', function() {
        exportUsersByCSV();
    });

    importButton.addEventListener('click', function() {
        const instructions = "Import csv";
        const instructionContainer = document.createElement('div');
        instructionContainer.id = 'importContainer';
        instructionContainer.style.display = 'flex';
        instructionContainer.style.flexDirection = 'column'
        const heading = document.createElement('h2');
        heading.innerHTML = 'Import csv';
        instructionContainer.appendChild(heading);
        instructionContainer.innerHTML = `
            <input class="space-y-2" type="file" id="import__input">
            <button class="space-y-4" onclick="importUsersByCSV()">Импортировать</button>
            <button class="bg-blue white border-0 hover:bg-blue-black-50 ease-in-out-2 cursor-pointer"
            style="width: 8rem; height: 2rem"
            onclick="closeContainer('importContainer')"
            >Закрыть</button>
        `;
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(instructionContainer);


    });

    infoButton.addEventListener('click', function() {
        const instructions = `Шаг 1: Выбор остановки на карте
    <br>
    1. Вы перешли на страницу веб-приложения "БресТранспорт".
    <br>
    2. На карте Google API выберите нужную остановку городского транспорта, кликнув по ней левой кнопкой мыши.
    <br>
    Шаг 2: Ввод данных о пассажире
    <br>
    1. После выбора остановки появится окно с полями для ввода данных о фиксаторе.
    <br>
    2. Введите следующие данные:
        <br>
        - ФИО: Введите полное имя с заглавной буквы, например, "Иванов Иван Иванович".
        <br>
        - Номер телефона: Начните с "+375", затем введите код оператора и номер в формате ***--.
        <br>
        - Логин: Введите адрес электронной почты в формате ivanon021@gmail.com.
        <br>
        - Пароль: Введите пароль, содержащий минимум 8 символов, по крайней мере одну заглавную букву и цифры.
    <br>
    Шаг 3: Сохранение данных
    <br>
    1. После заполнения всех полей нажмите кнопку "Сохранить", чтобы сохранить данные о фиксаторе.
    <br>
    Шаг 4: Просмотр сохраненных данных. После сохранения данных у вас есть возможность просмотреть информацию о фиксаторах на данной остановке.
    <br>
    1. Для этого нажмите кнопку "Просмотр".
    <br>
    2. Вы увидите список сохраненных пассажиров со всей введенной информацией.
    <br>
    Шаг 5: Экспортирование. После сохранения данных у вас есть возможность экспортировать информацию о фиксаторах на всех остановках.
    <br>
    1. Для этого нажмите кнопку "Экспортировать в csv".
    <br>
    2. Вы увидите загруженный файл user.csv в котором будет список сохраненных фиксаторов со всей введенной информацией.
    <br>
    Шаг 5: Импортированиие. Есть возможность импортировать информацию о пассажирах на всех остановках.
    <br>
    1. Для этого нажмите кнопку "Импортировать в csv".
    <br>
    2. Вы увидите окно в котором будет можно выбрать и добавить файл user.csv со список фиксаторов со всей введенной информацией.
`;

        var instructionContainer = document.createElement('div');
        instructionContainer.id = 'instructionContainer';

        var heading = document.createElement('h2');
        heading.innerHTML = 'Инструкции';
        instructionContainer.appendChild(heading);

        var instructionText = document.createElement('p');
        instructionText.innerHTML = instructions;
        instructionText.style.height = '400px';
        instructionText.style.overflowY = 'scroll';
        instructionContainer.appendChild(instructionText);

        var closeButton = document.createElement('button');
        closeButton.innerHTML = 'Закрыть';
        closeButton.addEventListener('click', function() {
            instructionContainer.parentNode.removeChild(instructionContainer);
        });
        instructionContainer.appendChild(closeButton);

        map.controls[google.maps.ControlPosition.TOP_CENTER].push(instructionContainer);
    });
}
function showData(id) {
    fetch(`http://localhost:8876/api/users/show`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: id
        })
    })
        .then(response => {
            return response.json()
        })
        .then(data => {
            console.log(data);
            const users = data.users;
            const popupElement = document.getElementById('show__popup');
            let list = ``;
            for (const user of users) {
                list += `<tr>
                             <td>${user.full_name}</td>
                             <td>${user.phone_number}</td>
                             <td>${user.email}</td>
                             <td>${user.password}</td>
                             <td class="text-center">
                                <span class="cursor-pointer"
                                      onclick="deleteUser('${user.id}', '${id}')"
                                      >x</span>`;
            }
            popupElement.style.display = 'block';
            popupElement.innerHTML = `
            <div class="flex row justify-end">
                <span class="cursor-pointer"
                      onclick="closePopup()"
                >x</span>
            </div>
            <table border="3px">
                <tr>
                    <th>ФИО</th>
                    <th>Номер телефона</th>
                    <th>Логин</th>
                    <th>Пароль</th>
                    <th>Взаимодействие</th>
                </tr>
            ${list}
            </table>
`
        })
        .catch(() => {
            const popupElement = document.getElementById('show__popup');
            popupElement.style.display = 'block';
            popupElement.innerHTML = `
            <div class="flex row justify-end">
                <span class="cursor-pointer"
                      onclick="closePopup()"
                >x</span>
            </div>
            <h1>Остановка: ${title}</h1>
            <table border="3px">
                <tr>
                    <th>ФИО</th>
                    <th>Номер телефона</th>
                    <th>Логин</th>
                    <th>Пароль</th>
                    <th>Взаимодействие</th>
                </tr>
            </table>`;
        });
}

const closePopup = () => {
    const popupElement = document.getElementById('show__popup');
    popupElement.style.display = 'none';
}

const deleteUser = (id, busStopId) => {
    fetch(`http://localhost:8876/api/users/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            return response.json()
        })
        .then(() => {
            showData(busStopId);
        })
        .catch(error => console.error('Error loading data:', error));
}

const importUsersByCSV = () => {
    let fileInput = document.getElementById('import__input');

    if (fileInput.files.length === 0) {
        console.error('Файл не выбран');
        return;
    }

    const file = fileInput.files[0];
    const form = new FormData();
    form.append('file', file);
    console.log(form);
    fetch('http://localhost:8876/api/users/import', {
        method: 'POST',
        body: form,
    }).then(response => {
        console.log(response);
    }).catch(error => {
        console.log(error);
    })
}

const exportUsersByCSV = () => {
    fetch('http://localhost:8876/api/users/export', {
        method: 'POST',
    }).then(response => {
        if (response.ok) {
            return response.blob();
        }
        throw new Error('Network response was not ok');
    }).then(blob => {

        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'users.csv');

        document.body.appendChild(link);

        link.click();

        link.parentNode.removeChild(link);

    }).catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}

function closeContainer(container) {
    document.getElementById(container).remove()
}

window.initMap = initMap;
