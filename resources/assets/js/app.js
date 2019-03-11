
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// global.$ = global.jQuery = require('jquery');
require('./bootstrap');
require('datatables.net');
require('./table');
require('./dashboard');
require('./pricing');

// $('[data-toggle="tooltip"]').tooltip()

// window.Vue = require('vue');


const shortUrlForm = document.getElementById('linkform');
const linkBox = document.getElementById('linkBox');
const shorLink = document.getElementById('shortLink');
const linkStats = document.getElementById('linkStats');

if (shortUrlForm) {
    shortUrlForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(shortUrlForm);

        axios.post('/link', formData)
            .then((response) => {
                shorLink.value = response.data.url;
                linkStats.textContent = response.data.stats.length;
                linkBox.classList.add('c-link-box--visible');
            })
            .catch((e) => {
                console.log(e);
            })

    });
}


const linkInput = document.querySelector('.c-link-input__input');

if (linkInput) {
    linkInput.addEventListener('focus', onLinkFocus);
    linkInput.addEventListener('blur', onLinkBlur);
}


const inputs = document.querySelectorAll('.c-pricing-modal__input');
Array.prototype.forEach.call(inputs, input => {
    input.addEventListener('focus', onLinkFocus);
    input.addEventListener('blur', onLinkBlur);
});

function onLinkFocus(e) {
    e.target.classList.add('is-changed');
}

function onLinkBlur(e) {
    if (e.target.value.trim() === '') {
        e.target.classList.remove('is-changed');
    }
}


/// SVG CHECKBOX
const trackedCheckbox = document.querySelector('.c-link-input-checkbox__input');
const scribleDef = 'm6.987,4.774c15.308,3.603453 30.731,2.276379 46.101,2.276379c9.74,0 19.484,0.136778 29.225,0.001628c2.152,-0.02931 4.358,-1.019323 6.229,1.955602c-5.443,2.090752 -10.857,4.201044 -16.398,4.109858c-9.586,-0.156318 -18.983,3.795594 -28.597,3.787453c-7.43,-0.004885 -14.988,-0.688776 -22.364,1.695072c-4.099,1.320561 -7.216,6.444857 -10.759,11.088801c8.981,-0.169344 17.952,3.21103 26.97,3.158924c8.365,-0.047221 16.557,-1.901868 24.872,-3.007491c2.436,-0.325662 24.209,-7.903824 24.632,3.619736c-14.265,8.786369 -29.483,1.561551 -43.871,0.854864c-12.163,-0.599219 -24.866,4.459945 -36.677,11.175102c14.93,6.897528 30.265,3.35595 45.365,3.948655c7.82,0.304494 15.486,3.139385 23.337,3.098677c2.602,-0.013026 6.644,-1.602259 9,0.76205c-2.584,2.921191 -8.164,1.602259 -10.809,1.896983c-13.329,1.463852 -26.632,3.769541 -39.939,6.436715c-6.761,1.358012 -13.413,1.546896 -20.204,1.527356c-1.429,-0.001628 -2.938,-0.252388 -4.142,0.709944c5.065,7.620498 15.128,4.645573 20.742,4.728617c11.342,0.169344 22.689,-0.131893 34.035,-0.131893c9.067,0 20.104,-3.927487 29.014,1.047004c-4.061,6.902413 -12.383,5.518348 -17.056,6.988713c-11.054,3.47156 -21.575,8.208318 -32.725,8.61214c-5.591,0.201911 -11.278,1.62994 -16.824,3.399914c-4.515,1.441056 -9.461,1.3401 -13.881,3.746745c2.302,5.1878 7.315,4.217327 10.13,4.386671';

function createSVG() {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttributeNS( null, 'viewBox', '0 0 100 100' );
    svg.setAttribute( 'xmlns', 'http://www.w3.org/2000/svg' );

    return svg;
}

function checkboxAddSvg(checkbox) {
    const svg = createSVG(scribleDef);
    checkbox.parentNode.appendChild(svg);

    checkbox.addEventListener('change', () => {
        if(checkbox.checked) {
            draw(checkbox);
        } else {
            reset(checkbox)
        }
    })
}

function draw(el) {
    const animDef = { speed : .8, easing : 'ease-in' };
    const svg = el.parentNode.querySelector('svg');

    let path = document.createElementNS('http://www.w3.org/2000/svg', 'path' );
    svg.appendChild(path);

    path.setAttributeNS(null, 'd', scribleDef);
    let length = path.getTotalLength();
    path.style.strokeDasharray = length + ' ' + length;
    path.style.strokeDashoffset = Math.floor(length) - 1;
    path.getBoundingClientRect();

    path.style.transition = path.style.WebkitTransition = path.style.MozTransition  = 'stroke-dashoffset ' + animDef.speed + 's ' + animDef.easing;
    path.style.strokeDashoffset = '0';
}

function reset(el) {
    let path = el.parentNode.querySelector('svg > path');
    path.parentNode.removeChild(path)
}

if (trackedCheckbox) {
    checkboxAddSvg(trackedCheckbox);
}


import Chart from 'chart.js';

if (document.getElementById('linechart')) {

    const lineChart = document.getElementById('linechart').getContext('2d');
    const gradient = lineChart.createLinearGradient(0, 0, 0, 300);

    gradient.addColorStop(0, 'rgba(0, 123, 255, 0.5)');
    gradient.addColorStop(0.8, 'rgba(0, 123, 255, 0)');

    Chart.defaults.global.legend.display = false;
    Chart.defaults.global.tooltips.enabled = false;


    const options = {
        responsive: true,
        maintainAspectRatio: false,
        elements: {
            arc: {
                borderWidth: 0
            }
        },
        legend: {
            display: false
        },
        tooltips: {
            enabled: false
        }
    }

    const segment1Chart = new Chart('segchar1', {
        type: 'doughnut',
        data: {
            datasets: [{
                backgroundColor: ['#A87EEF', '#F0F1F3'],
                data: [36, 64]
            }]
        },
        options: options
    });

    const segment2Chart = new Chart('segchar2', {
        type: 'doughnut',
        data: {
            datasets: [{
                backgroundColor: ['#508FFF', '#F0F1F3'],
                data: [42, 58]
            }]
        },
        options: options
    });

    const segment3Chart = new Chart('segchar3', {
        type: 'doughnut',
        data: {
            datasets: [{
                backgroundColor: ['#42B5A3', '#F0F1F3'],
                data: [22, 78]
            }]
        },
        options: options
    });

    const lineData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
            fill: true,
            label: 'Custom Label Name',
            backgroundColor: gradient,
            pointBackgroundColor: '#007bff',
            borderWidth: 1,
            borderColor: '#007bff',
            data: [10, 17, 5, 23, 18, 28]
        }]
    };


    const lineOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                }
            }],
            yAxes: [{
                gridLines: {
                    drawBorder: false,
                    color: 'rgba(200, 200, 200, 0.1)',
                    lineWidth: 1
                }
            }]
        },
        elements: {
            line: {
                tension: 0.4
            }
        },
        point: {
            backgroundColor: 'white'
        },
        // tooltips: {
        //     titleFontFamily: 'Open Sans',
        //     backgroundColor: 'rgba(0,0,0,0.3)',
        //     titleFontColor: 'red',
        //     caretSize: 5,
        //     cornerRadius: 2,
        //     xPadding: 10,
        //     yPadding: 10
        // }
    };

    const ln = new Chart(lineChart, {
        type: 'line',
        data: lineData,
        options: lineOptions
    })
}
