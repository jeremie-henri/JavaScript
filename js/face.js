loadjQuery(function() {
    $('body').empty();
    let getRandomInt = function (max) {
        return Math.floor(Math.random() * Math.floor(max));
    };
    let curr=getRandomInt(5000);
    let addNewAvatar=function() {
        $('body').append(
            $('<img />').attr(
                'src', 'https://graph.facebook.com/'+curr+'/picture?type=normal'
            ).css({
                'max-width': '50px',
                'display': 'inline-block',
                'float': 'left',
                'margin': '0',
                'padding': '0'
            })
        );
        curr += (1+getRandomInt(3));
        setTimeout(addNewAvatar, 100);
    };
    setTimeout(addNewAvatar, 100);
});