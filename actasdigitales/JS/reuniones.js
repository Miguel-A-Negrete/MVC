document.addEventListener('DOMContentLoaded', function () {
    fetch('index.php?route=meetings&action=participantsForMeeting')
        .then(response => response.json())
        .then(data => {
            const meetingNames = data.map(meeting => meeting.title);
            const numParticipants = data.map(meeting => meeting.num_participants);

            const ctx = document.getElementById('participantsChart').getContext('2d');
            const participantsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meetingNames,
                    datasets: [{
                        label: '# de Participantes',
                        data: numParticipants,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching participants data:', error));
});
