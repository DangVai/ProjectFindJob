function deleteRow(id_post) {
    if (!confirm("Are you sure you want to delete this post?")) {
        return;
    }
    fetch('delete/delete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id_post=${id_post}`
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok " + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            if (data.trim() === "success") {
                const row = document.getElementById(`row-${id_post}`);
                if (row) row.remove();
                alert("Post deleted successfully!");
            } else {
                alert("Error deleting post: " + data);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Failed to delete. Please try again later.");
        });
}