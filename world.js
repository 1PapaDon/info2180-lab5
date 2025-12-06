window.onload = () => {
    const lookupBtn = document.getElementById("lookup");
    const cityLookupBtn = document.getElementById("cityLookup");
    const resultDiv = document.getElementById("result");
    const countryInput = document.getElementById("country");

    // Lookup Country button
    lookupBtn.onclick = () => {
        const country = countryInput.value;
        resultDiv.innerHTML = "<p>Loading countries...</p>";

        fetch(`world.php?country=${encodeURIComponent(country)}`)
            .then(response => response.text())
            .then(data => resultDiv.innerHTML = data)
            .catch(error => {
                resultDiv.innerHTML = '<p>Error loading data.</p>';
                console.error('Error:', error);
            });
    };

    // Lookup Cities button
    cityLookupBtn.onclick = () => {
        const country = countryInput.value;
        resultDiv.innerHTML = "<p>Loading cities...</p>";

        fetch(`world.php?country=${encodeURIComponent(country)}&lookup=cities`)
            .then(response => response.text())
            .then(data => resultDiv.innerHTML = data)
            .catch(error => {
                resultDiv.innerHTML = '<p>Error loading data.</p>';
                console.error('Error:', error);
            });
    };
};