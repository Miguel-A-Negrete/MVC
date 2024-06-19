document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('../actasdigitales/controladores/UsersController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                console.log(response)
                throw new Error('Error en la solicitud: ' + response.status);
            }
            return response.json(); // Parse JSON asynchronously
        })
        .then(data => {
            console.log('Token recibido:', data); // Verifica que recibas el token correctamente
            localStorage.setItem('jwtToken', data.token);
            window.location.href = '../actasdigitales/index.php?token=' + data.token;
        })
        .catch(error => {
            console.error('Error al realizar la petición:', error);
            alert('Error al iniciar sesión. Por favor, inténtalo de nuevo.');
        });
    });
});