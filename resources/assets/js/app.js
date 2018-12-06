
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



const headerCollapse = document.getElementById('openinfo');
const headerInfo = document.getElementById('info');

const urlInput = document.getElementById('url');
const emailInput = document.getElementById('email');

// http://forums.devshed.com/javascript-development-115/regexp-match-url-pattern-493764.html
const urlPattern = /^(https?:\/\/)?((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|((\d{1,3}\.){3}\d{1,3}))(\:\d+)?(\/[-a-z\d%_.~+]*)*(\?[;&a-z\d%_.~+=-]*)?(\#[-a-z\d_]*)?$/;

// http://emailregex.com/
const emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

if ( headerCollapse ) {
    headerCollapse.addEventListener('click', () => {
        if (headerInfo.classList.contains('open') && emailInput.value !== '') {
            return;
        }

        headerInfo.classList.toggle('open');
        headerCollapse.classList.toggle('open');
    });
}


function checkUrl() {
    if(urlPattern.test(this.value)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    }
}



function checkEmail() {
    if(emailPattern.test(this.value)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    }
}

if (urlInput) {
    urlInput.addEventListener('keydown', checkUrl);
    urlInput.addEventListener('paste', checkUrl);
    urlInput.addEventListener('cut', checkUrl);

    emailInput.addEventListener('keydown', checkEmail);
    emailInput.addEventListener('paste', checkEmail);
    emailInput.addEventListener('cut', checkEmail);



    const shortenForm = document.getElementById('shorten');
    const alert = document.querySelector('.shorturl-alert');
    const linkContainer = alert.querySelector('.shortlink-input');


    shortenForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const url = urlInput.value
        const email = emailInput.value

        const toSend = {
            url,
        };

        if (headerInfo.classList.contains('open')) toSend.email = email

        axios.post('/api/cut', toSend).then(function (response) {
            alert.style.display = 'block';
            linkContainer.value = response.data.url
            linkContainer.focus();
            console.log(response.data);
        })
        .catch(function (error) {
            if (error.response.status === 401) {
                window.location.href = '/login';
            }
        });
    })
}