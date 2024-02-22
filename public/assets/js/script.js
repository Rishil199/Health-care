$(document).ready(function() {
    $(document).on('click', '.header-btn .btn', function() {
        // $('.header-upper-right').toggleClass('open');
        $('.header-lower').toggleClass('open');
        $('.dashboard_body').toggleClass('open');

    });
    $(document).on('click', '.hur-block .close', function() {
        // $('.header-upper-right').removeClass('open');
        $('.header-lower').removeClass('open');
        $('.dashboard_body').toggleClass('open');
    });


    // APEAX Chart
    if (document.querySelector("#montlyEarnings")) {
        var options = {
            series: [0],
            chart: {

                height: '350',
                type: 'radialBar',
                fontFamily: 'Inter, sans-serif',
                offsetY: 20,
                selection: {
                    enabled: true
                },
                toolbar: {
                    show: true

                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -100,
                    endAngle: 100,
                    dataLabels: {
                        name: {
                            fontSize: '14',
                            color: undefined,
                            // offsetY: 150
                        },
                        value: {
                            // offsetY: 100,
                            fontSize: '18px',
                            color: undefined,
                            formatter: function(val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                // type: 'gradient',    
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [66, 70, 130, 20]
                },
            },
            stroke: {
                dashArray: 4
            },
            labels: ['Median Ratio'],
        };

        var chart = new ApexCharts(document.querySelector("#montlyEarnings"), options);
        chart.render();
    }

    if (document.querySelector("#registeredUser")) {
        var options = {

            colors: ['#7579E7', '#ddd'],
            markers: {
                colors: ['#26282B']
            },
            series: [{
                name: 'Patients',
                type: 'column',
                data: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60]
            }, {
                name: 'Revenue',
                type: 'line',
                data: [1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000, 11000, 112000]
            }],
            chart: {
                height: 305,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            stroke: {
                width: [0, 4]
            },
            xaxis: {
                //type: 'datetime'
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: {
                    style: {
                        fontFamily: 'Inter, sans-serif',
                        fontSize: '10px',
                        cssClass: 'smallFont',
                    }
                }
            },

            yaxis: [{
                title: {
                    text: 'No. of Patients',

                    style: {
                        fontSize: '10px',
                        fontFamily: 'Inter, sans-serif',
                        fontWeight: 'bold',
                        cssClass: 'smallFont',
                    }

                },
                label: {
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Inter, sans-serif',
                        fontWeight: 'bold',
                    }
                }

            }, {
                opposite: true,
                title: {
                    text: '$ (thousands)'
                }
            }],
            // responsive: [{
            //     breakpoint: 1000,
            //     options: {
            //         opposite: false,
            //         title: {
            //             text: false
            //         }
            //     }
            // }]
        };

        var monthly_user_chart = new ApexCharts(document.querySelector("#registeredUser"), options);
        monthly_user_chart.render();
    }

    $(window).resize(function() {
            console.log('resize called');
            var width = $(window).width();
            if (width <= 960) {
                $('.header-upper-right').removeClass('open');
            }
        })
        .resize();

    $(document).on('click', '.first,#alertWarning', function() {
        Swal.fire({
            background: '#ffeac8',
            iconHtml: '<div class="icon warning"><svg height="30" viewBox="0 0 512 512" width="30" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" d="M449.07,399.08,278.64,82.58c-12.08-22.44-44.26-22.44-56.35,0L51.87,399.08A32,32,0,0,0,80,446.25H420.89A32,32,0,0,0,449.07,399.08Zm-198.6-1.83a20,20,0,1,1,20-20A20,20,0,0,1,250.47,397.25ZM272.19,196.1l-5.74,122a16,16,0,0,1-32,0l-5.74-121.95v0a21.73,21.73,0,0,1,21.5-22.69h.21a21.74,21.74,0,0,1,21.73,22.7Z"></path></svg></div>',
            color: ' #EF9400',
            iconColor: ' #EF9400',
            closeButtonColor: ' #EF9400',
            toast: true,
            icon: 'success',
            title: 'Warning Message here',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: false,
            allowOutsideClick: false,
            showCloseButton: true,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                closeButton: 'warning-close',
                container: 'warning-container',
            }
        });
    });

    $(document).on('click', '#alertPrimary', function() {

        Swal.fire({
            background: '#def5e5',
            iconHtml: '<div class="icon success"><svg width="30" height="30" id="Layer_1" style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><circle fill="#fff" cx="64" cy="64" r="64"></circle></g><g><path fill="#3EBD61" d="M54.3,97.2L24.8,67.7c-0.4-0.4-0.4-1,0-1.4l8.5-8.5c0.4-0.4,1-0.4,1.4,0L55,78.1l38.2-38.2   c0.4-0.4,1-0.4,1.4,0l8.5,8.5c0.4,0.4,0.4,1,0,1.4L55.7,97.2C55.3,97.6,54.7,97.6,54.3,97.2z"></path></g></svg></div>',
            color: '#395144',
            iconColor: '#395144',
            closeButtonColor: '#395144',

            toast: true,
            icon: 'success',
            title: 'Success Message here',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            allowOutsideClick: false,
            showCloseButton: true,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                closeButton: 'success-close',
                container: 'success-container',
                timerProgressBar: 'success-progress',
            }
        });


    });
    $(document).on('click', '#alertError', function() {

        Swal.fire({
            background: '#ffe8e3',
            iconHtml: '<div class="icon danger"><svg height="30" viewBox="0 0 512 512" width="30" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" d="M449.07,399.08,278.64,82.58c-12.08-22.44-44.26-22.44-56.35,0L51.87,399.08A32,32,0,0,0,80,446.25H420.89A32,32,0,0,0,449.07,399.08Zm-198.6-1.83a20,20,0,1,1,20-20A20,20,0,0,1,250.47,397.25ZM272.19,196.1l-5.74,122a16,16,0,0,1-32,0l-5.74-121.95v0a21.73,21.73,0,0,1,21.5-22.69h.21a21.74,21.74,0,0,1,21.73,22.7Z"></path></svg></div>',
            color: '#EC4D2B',
            iconColor: '#FB2576',
            closeButtonColor: '#FB2576',
            toast: true,
            icon: 'success',

            title: 'Error Message here',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: false,
            allowOutsideClick: false,
            showCloseButton: true,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                closeButton: 'danger-close',
                container: 'danger-container',
            }
        });

    });
    $(document).on('click', '#alertInfo', function() {
        Swal.fire({
            background: '#dbe7f3',
            iconHtml: '<div class="icon info"><svg height="30" viewBox="0 0 512 512" width="30" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" d="M449.07,399.08,278.64,82.58c-12.08-22.44-44.26-22.44-56.35,0L51.87,399.08A32,32,0,0,0,80,446.25H420.89A32,32,0,0,0,449.07,399.08Zm-198.6-1.83a20,20,0,1,1,20-20A20,20,0,0,1,250.47,397.25ZM272.19,196.1l-5.74,122a16,16,0,0,1-32,0l-5.74-121.95v0a21.73,21.73,0,0,1,21.5-22.69h.21a21.74,21.74,0,0,1,21.73,22.7Z"></path></svg></div>',
            color: '#006CE3',
            iconColor: '#006CE3',
            closeButtonColor: '#006CE3',
            toast: true,
            icon: 'success',

            title: 'Info Message here',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: false,
            allowOutsideClick: false,
            showCloseButton: true,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                closeButton: 'info-close',
                container: 'info-container',
            }
        });

    });
    $('a[href^="#"]').on('click', function(e) {
        var target = this.hash,
            $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top - 87
        }, 500, 'swing', function() {
            window.location.hash = target;
        });
    });
});