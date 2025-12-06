window.onload = () => {
    const lookupBtn = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");

    lookupBtn.onclick = () => {
        const country = document.getElementById("country").value;
        
        fetch(`world.php?country=${country}`)
            .then(response => response.text())
            .then(data => resultDiv.innerHTML = data);
    };
};