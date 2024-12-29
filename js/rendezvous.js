document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("rendezvousForm");
    const messageDiv = document.getElementById("message");
    const patientSelect = document.getElementById("patientId");
    const medecinSelect = document.getElementById("medecinId");

    // Charger les patients dynamiquement
    fetch("getPatients.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.patients.forEach(patient => {
                    const option = document.createElement("option");
                    option.value = patient.id;
                    option.textContent = patient.name;
                    patientSelect.appendChild(option);
                });
            } else {
                messageDiv.textContent = "Erreur lors du chargement des patients.";
                messageDiv.className = "alert alert-danger";
            }
        });

    // Charger les médecins dynamiquement
    fetch("getDoctors.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.medecins.forEach(medecin => {
                    const option = document.createElement("option");
                    option.value = medecin.id;
                    option.textContent = medecin.name;
                    medecinSelect.appendChild(option);
                });
            } else {
                messageDiv.textContent = "Erreur lors du chargement des médecins.";
                messageDiv.className = "alert alert-danger";
            }
        });

    // Soumettre le formulaire
    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const patientId = patientSelect.value;
        const medecinId = medecinSelect.value;
        const date = document.getElementById("date").value;
        const heure = document.getElementById("heure").value;

        if (!patientId || !medecinId || !date || !heure) {
            messageDiv.textContent = "Tous les champs sont obligatoires.";
            messageDiv.className = "alert alert-danger";
            return;
        }

        const formData = new FormData(form);
        formData.append("action", "addRendezvous");

        fetch("rendezvous.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.textContent = "Rendez-vous ajouté avec succès !";
                messageDiv.className = "alert alert-success";
                form.reset();
            } else {
                messageDiv.textContent = data.message || "Erreur lors de la prise du rendez-vous.";
                messageDiv.className = "alert alert-danger";
            }
        });
    });
});
