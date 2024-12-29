document.addEventListener("DOMContentLoaded", function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('calendrier.php?action=list')
                .then(response => response.json())
                .then(data => {
                    const events = data.map(event => ({
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        description: event.description
                    }));
                    successCallback(events);
                })
                .catch(error => {
                    alert('Impossible de charger les événements');
                    failureCallback(error);
                });
        },
        eventRender: function(info) {
            $(info.el).tooltip({
                title: info.event.extendedProps.description,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
            info.el.style.fontSize = '14px';
            info.el.style.padding = '5px';
        },
        eventLimit: true,
        eventLimitText: 'plus...',
        
        // Ajout de l'événement "dateClick"
        dateClick: function(info) {
            // Affiche tous les rendez-vous de la journée cliquée
            var selectedDate = info.dateStr;  // Format : "yyyy-mm-dd"
            
            // Récupérer les rendez-vous de cette journée via AJAX
            fetch(`calendrier.php?action=listByDate&date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // Afficher les rendez-vous dans un modal ou une autre section
                        let modalContent = `<h5>Rendez-vous pour le ${selectedDate}</h5>`;
                        data.forEach(event => {
                            modalContent += `
                                <div>
                                    <h6>${event.title}</h6>
                                    <p><strong>Heure :</strong> ${event.start}</p>
                                    <p><strong>Description :</strong> ${event.description}</p>
                                </div>
                                <hr>
                            `;
                        });
                        // Affiche le contenu dans un modal ou une section dédiée
                        document.getElementById("appointmentsModalContent").innerHTML = modalContent;
                        // Ouvre le modal (ou affiche la section)
                        $('#appointmentsModal').modal('show');
                    } else {
                        alert("Aucun rendez-vous pour cette date.");
                    }
                })
                .catch(error => {
                    alert('Impossible de charger les rendez-vous');
                    console.error(error);
                });
        }
    });

    calendar.render();
});
