const authChangeBtn = document.querySelector(".auth__change");
const authSubmitBtn = document.querySelector(".auth__submit");

//отслеживаем событие "click" на элементах. 
//Знак ? поможет избавиться от ошибки в случае, если элемент не будет отредерен на страницe 
authChangeBtn?.addEventListener("click", authChange);
authSubmitBtn?.addEventListener("click", authSubmit);

/**
 * Функция authSubmit() получает данные с формы и отправляет их сервер
 */
function authSubmit() {
    const form = document.querySelector("FORM.auth");
    const formData = new FormData(form);

    const action = this.value;

    const promise = sendAjax("Controller.php", "POST", "json", {
        action: action,
        data: {
            login: formData.get("login"),
            pass: formData.get("password"),
        }
    });

    promise.then(
        resolve => {window.location.href = resolve.redirect},
        reject => {
            let message = "Ошибка:\n";
            reject.error.forEach(er => { message += er+"\n"; });
            alert(message);
        }
    );
}   

/**
 * Функция authChange() позволяет выбрать действие (Зарегистрироваться или Авторизироваться)
 */
function authChange() {
    const authTitle = document.querySelector(".auth__tile");
    const authSubmit = document.querySelector(".auth__submit");

    if (this.value === "Зарегистрироваться") {
        this.value = "Войти";
        authTitle.innerText = "Регистрация";

        authSubmit.innerText = "Зарегистрироваться";
        authSubmit.value = "signIn";

    } else {
        this.value = "Зарегистрироваться";
        authTitle.innerText = "Авторизация";

        authSubmit.innerText = "Войти";
        authSubmit.value = "logIn";
    }
}

/**
 * sendAjax() Отправляет данные на сервер и ждет ответа от сервера. 
 * Promise позволяет нам дождаться ответа от сервера
 * Успешные ответы помещаем в resolve, а неуспешные в reject
 * 
 * @param {string} url //то, куда мы отправляем данные. Пример: "Controller.php"
 * @param {string} method //метод отправки данных. Пример: "POST"
 * @param {string} dataType //формат принятых данных от сервера. Пример: "json"
 * @param {object} object //объект, который необходимо отправить на сервер
 * @returns 
 */
function sendAjax(url, method, dataType, object = {}) {

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: method,
            dataType: dataType,
            data: object,
            success: function(data){ 
                if (data) {
                    if (data.status) {resolve(data); return true;}
                    reject(data)
                }
            },
            error: function (jqXHR, exception) {
                if (jqXHR.status === 0) {
                    reject('Not connect. Verify Network.');
                } else if (jqXHR.status == 404) {
                    reject('Requested page not found (404).');
                } else if (jqXHR.status == 500) {
                    reject('Internal Server Error (500).');
                } else if (exception === 'parsererror') {
                    reject('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    reject('Time out error.');
                } else if (exception === 'abort') {
                    reject('Ajax request aborted.');
                } else {
                    reject('Uncaught Error. ' + jqXHR.responseText);
                }
            }
        });

    });
}