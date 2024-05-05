async function initMap() {

    const map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 52.093752, lng: 23.740995},
        zoom: 12
    });
    const image = "https://www.google.by/maps/vt/icon/name=assets/icons/transit/quantum_v2/bus-0-tiny.png&scale=2"

    fetch('./js/data.json')
        .then(response => response.json())
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
                    content: '<div><strong>' + markerData.title +
                        '</strong><br><label for="fullName">ФИО:</label><br><input type="text" id="fullName">' +
                        '<br><label for="phoneNumber">Номер телефона:</label><br><input type="text" id="phoneNumber">' +
                        '<br><label for="email">Логин:</label><br><input type="text" id="email">' +
                        '<br><label for="password">Пароль:</label><br><input type="text" id="password">' +
                        `<br><br><button onclick="saveData('${markerData.title}')">Сохранить</button></div>` +
                        `<br><button onclick="showData('${markerData.title}')">Просмотр</button></div>`
                });
                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });


}

function saveData(title) {
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
            title: title,
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


function showData(title) {
    fetch(`http://localhost:8876/api/users/show`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            title: title,
        })
    })
        .then(response => {
            return response.json()
        })
        .then(data => {
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
                                      onclick="deleteUser('${user.id}', '${title}')"
                                >X</span>
                             </td>
                         </tr>`;
            }
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

const deleteUser = (id, title) => {
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
            showData(title);
        })
        .catch(error => console.error('Error loading data:', error));
}


window.initMap = initMap;
