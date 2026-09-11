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
  <div class="commentSection comment-section">
    <form id="commentForm" class="comment-form">
      <h4 class="comment-form-title">Add a Comment</h4>
      <input class="comment-input comment-email" type="email" id="emailInput" placeholder="Email" required>
      <input class="comment-input comment-name" type="text" id="nameInput" placeholder="Name" required>
      <textarea class="comment-input comment-body" id="commentInput" placeholder="Add a comment..." required></textarea>
      <button class="comment-submit" type="submit">Post Comment</button>
    </form>
    <h3 class="comments-title">Comments</h3>
    <!-- <ul id="commentList"></ul> -->
    <div id="card-grid" class="comments-grid"></div>
    <div id="loading" class="comments-loading">Loading...</div>
  </div>
</body>

</html>

<script>
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

    if (result.success) {
      emailInput.value = "";
      nameInput.value = "";
      commentInput.value = "";
      await fetchComments();
    } else {
      console.error(result.message);
    }
  });
</script>


<script>
  fetch('./api/list.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {})
    .catch(error => console.error('Error fetching comments:', error));

  const container = document.getElementById('card-grid');
  const loading = document.getElementById('loading');

  async function fetchComments() {
    try {
      const response = await fetch('./api/list.php');
      if (!response.ok) throw new Error('Failed to load comments');
      const data = await response.json();
      allComments = data.records;
      renderComments(allComments);
      console.log('Comments fetched:', allComments);
    } catch (error) {

      console.error('Error fetching comments:', error);
      loading.innerHTML = `<div class="error-msg">Error: ${error.message}. Please make sure the API is running.</div>
        `;
    }
  }


  function renderComments(comments) {

    loading.style.display = 'none';

    for (const comment of comments) {
      const sectionId = comment.id;
      let section = document.getElementById(sectionId);


      if (!section) {
        section = document.createElement('div');
        section.className = 'category comment';
        section.id = sectionId;

        section.innerHTML = `
                <article class="card comment-card">
                    <h3>${comment.name} </h3> <p>${comment.created_at}</p>
                    <p>${comment.comment}</p>
                </article>
        `;
        container.appendChild(section);
      }
    }
  }

  fetchComments();
</script>