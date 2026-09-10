<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <video width="400" controls>
        <source src="mov_bbb.mp4" type="video/mp4">
        <source src="mov_bbb.ogg" type="video/ogg">
        Your browser does not support HTML video.
    </video>
    <div class="commentSection">
        <form id="commentForm">
            <h4>Add a Comment</h4>
            <input type="email" id="emailInput" placeholder="Email" required>
            <input type="text" id="nameInput" placeholder="Name" required>
            <input type="text" id="commentInput" placeholder="Add a comment..." required style="height: 100px;">
            <button cl type="submit">Post Comment</button>
        </form>
        <p id="message"></p>
        <h3>Comments</h3>
        <ul id="commentList"></ul>

    </div>
</body>

</html>

<script>
    const message = document.getElementById("message");
    form = document.getElementById('commentForm');
    emailInput = document.getElementById('emailInput');
    nameInput = document.getElementById('nameInput');
    commentInput = document.getElementById('commentInput');



    
    form.addEventListener("submit", async function(e) {

        e.preventDefault();

            const formData = new FormData();
            
            formData.append("email", emailInput.value);
            formData.append("name", nameInput.value);
            formData.append("comment", commentInput.value);

            let url = "./api/create.php";

            const response = await fetch(url, {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            message.textContent = result.message || "Opgeslagen.";

            emailInput.value = "";
            nameInput.value = "";
            commentInput.value = "";
        });


    function renderLocations(locations) {

      loading.style.display = 'none';

      for (const location of locations) {
        const sectionId = location.id;
        let section = document.getElementById(sectionId);


        if (!section) {
          section = document.createElement('div');
          section.className = 'category.location';
          section.id = sectionId;

          section.innerHTML = `
          <article class="cms-item">
            <div>
              <h3>${location.locatie}</h3>
              <p>${location.beschrijving}</p>
            </div>
            <div class="cms-item__actions">
              <button type="button" class="btn btn--primary delete-btn" data-action="delete" data-id="${location.id}">Verwijderen</button>
            </div>
          </article>
          `;
          container.appendChild(section);
        }
        document.querySelectorAll(".delete-btn").forEach(btn => {
          btn.addEventListener("click", deleteLocation);
        });
      }
    }

    
</script>