document.onclick =  function(e){

    if(e.target.closest('#showUsersTable')) {
    
        let usersCard = document.getElementById('usersCard');
        
        if(usersCard.classList.contains('d-none')) {
            usersCard.classList.remove('d-none');
            $('#usersTable').DataTable(populateUsersDb());
        } else {
            usersCard.classList.add('d-none')
        } 
        closeCardSiblings('usersCard');
    }

    if(e.target.classList.contains('deleteUser')) {

        let metaElement = document.getElementsByName('csrf-token');
        let csrf = metaElement[0].getAttribute('content');

        let id = e.target.dataset.id;

        let formData = new FormData;
        formData.append('id',id)
        formData.append('_token', csrf)

        fetch( '/admin/users/delete',{
            method: 'post',
            body: formData,
            credentials: 'same-origin'
         }
        )
        .then(response => response.status)
        .then(status => {
            if(status == 200) { 
                $('#usersTable').DataTable(populateUsersDb());
                $(document).Toasts('create', {
                    title: 'Succeeded!',
                    body: 'The user was deleted.',
                    class: 'btn-success',
                })
               
            }
        })
    }

    if(e.target.closest('#showSessionsTable')) {
 
        let sessionsCard = document.getElementById('sessionsCard');
        
        if(sessionsCard.classList.contains('d-none')) {
            sessionsCard.classList.remove('d-none');
             $('#sessionsTable').DataTable(populateSessionsDb());
        } else {
            sessionsCard.classList.add('d-none')
        } 
        closeCardSiblings('sessionsCard')
    }

};

function populateUsersDb() {
    return {
        ajax: {
            url: '/admin/users',
            dataSrc: "data"
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: null,
                render: function(data, type, row, meta)
                    {
                    return `<button class="deleteUser btn btn-danger" data-id= ${data.id} >DeleteUser</button> `
                    }
            }
        ],
        
        "pageLength": 3,
        "bDestroy": true,
        "columnDefs": [
            {"className": "dt-center", "targets": "_all"}
            ]
    }
}

function populateSessionsDb() 
{
    let cookie = getCookie('sessionId');

    return {
        ajax: {
            url: '/admin/sessions',
            dataSrc: "data"
        },
        columns: [
            { data: 'id' },
            { data: 'session_id' },
            { data: 'ip' },
            { data: 'country' },
            { data: 'browser' },
            { data: null,
                render: function(data, type, row, meta)
                    {
                    let logged = 'not Logged';
                    let btnClass = 'btn-info';
                    if(data.session_id == cookie) { logged = 'Logged'; $btnClass = 'btn-success'}

                    return `<button class=" btn ${btnClass}">${logged}</button> `
                    }
            }
        ],
        
        "pageLength": 3,
        "bDestroy": true,
        "columnDefs": [
            {"className": "dt-center", "targets": "_all"}
            ]
    }
}

function getCookie(cookieName) 
{
    let cookie = {};
    document.cookie.split(';').forEach(function(el) {
        let [key,value] = el.split('=');
        cookie[key.trim()] = value;
    })
    return cookie[cookieName];
    }

function closeCardSiblings(currentId)
{
    let siblings = document.querySelectorAll('.card');
    siblings.forEach(element => {
        if(element.id != currentId ) {
            element.classList.add('d-none');
        }
    });
}