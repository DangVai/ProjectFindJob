document.addEventListener("DOMContentLoaded", () => {
    const filterItemsAddress = document.querySelectorAll(".fifter-address h2");
    const filterItemsField = document.querySelectorAll(".fifter-job h2");
    const posts = document.querySelectorAll(".post");

    // Lấy danh sách địa chỉ và lĩnh vực có trong bộ lọc (trừ "Khác")
    const filterAddresses = Array.from(filterItemsAddress)
        .map(item => item.textContent.trim())
        .filter(address => address !== "Khác");

    const filterFields = Array.from(filterItemsField)
        .map(item => item.textContent.trim())
        .filter(field => field !== "Khác");

    // Lọc bài viết theo địa chỉ
    filterItemsAddress.forEach(item => {
        item.addEventListener("click", () => {
            const selectedAddress = item.textContent.trim();

            posts.forEach(post => {
                const postAddress = post.getAttribute("data-address");

                if (selectedAddress === "Others") {
                    // Hiển thị bài viết không thuộc danh sách filterAddresses
                    if (!filterAddresses.includes(postAddress)) {
                        post.style.display = "flex";
                    } else {
                        post.style.display = "none";
                    }
                } else {
                    // Hiển thị bài viết có địa chỉ khớp với selectedAddress
                    if (postAddress === selectedAddress) {
                        post.style.display = "flex";
                    } else {
                        post.style.display = "none";
                    }
                }
            });
        });
    });

    // Lọc bài viết theo lĩnh vực
    filterItemsField.forEach(item => {
        item.addEventListener("click", () => {
            const selectedField = item.textContent.trim();

            posts.forEach(post => {
                const postField = post.getAttribute("data-field");

                if (selectedField === "Others") {
                    // Hiển thị bài viết không thuộc danh sách filterFields
                    if (!filterFields.includes(postField)) {
                        post.style.display = "flex";
                    } else {
                        post.style.display = "none";
                    }
                } else {
                    // Hiển thị bài viết có lĩnh vực khớp với selectedField
                    if (postField === selectedField) {
                        post.style.display = "flex";
                    } else {
                        post.style.display = "none";
                    }
                }
            });
        });
    });
});