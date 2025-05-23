// roombook.js

// Reference to the guest detail modal panel
const detailpanel = document.getElementById("guestdetailpanel");

// Open the guest reservation form panel
function adduseropen() {
    detailpanel.style.display = "flex";
}

// Close the guest reservation form panel
function adduserclose() {
    detailpanel.style.display = "none";
}

// Live search functionality on the room booking table
function searchFun() {
    const filter = document.getElementById('search_bar').value.toUpperCase();
    const myTable = document.getElementById("table-data");
    const tr = myTable.getElementsByTagName('tr');

    for (let i = 0; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td')[1]; // Assumes Name is in 2nd column
        if (td) {
            const textvalue = td.textContent || td.innerText;
            tr[i].style.display = textvalue.toUpperCase().includes(filter) ? "" : "none";
        }
    }
}
