document.addEventListener('DOMContentLoaded', function() {
    var searchButton = document.getElementById("searchId");
    var searchField = document.getElementById("searchField");
    var overlay = document.getElementById('overlay');
    var resultsDiv = document.getElementById('resultsId');
    var typingTimer;

    searchButton.addEventListener('click', function(event) {
        event.preventDefault(); 
        overlay.style.display = 'block';
    });

    overlay.addEventListener('click', function(event) {
        event.preventDefault(); 
        if (overlay === event.target) {
            overlay.style.display = 'none';
        }
    });

    searchField.addEventListener('keydown', typingLogic);

    function typingLogic() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(getResults, 700);
    }

    function getResults() {
        fetch(mainUrl.site_url + '/wp-json/wp/v2/movies?search=' + searchField.value)
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const dataHtml = `
                    <h2 class=""></h2>
                    <ul class="">
                        ${data.map(item =>  `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                    </ul>
            `;
            resultsDiv.innerHTML = dataHtml;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }

});
