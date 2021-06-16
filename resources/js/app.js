require('./bootstrap');

require('alpinejs');
Echo.channel('push')
    .listen('.push.msg', (e) => {
        alert('来了')
        console.log(e);
    });
