<!DOCTYPE html>
<html>
<head>
<title>College Gallery</title>

<style>

body{
    font-family: Arial;
    margin:0;
    background:#f4f4f4;
}

/* Buttons */

.filter-buttons{
    text-align:center;
    padding:20px;
}

.filter-buttons button{
    padding:10px 20px;
    margin:5px;
    border:none;
    background:#7b2c3b;
    color:white;
    cursor:pointer;
    font-weight:bold;
}

.filter-buttons button:hover{
    background:#5a1e29;
}

/* Gallery Grid */

.gallery{
    width:90%;
    margin:auto;
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:20px;
}

.gallery-item{
    position:relative;
    overflow:hidden;
}

.gallery-item img{
    width:100%;
    height:250px;
    object-fit:cover;
    transition:0.5s;
}

.gallery-item:hover img{
    transform:scale(1.1);
}

/* Overlay */

.overlay{
    position:absolute;
    bottom:0;
    background:rgba(0,0,0,0.6);
    color:white;
    width:100%;
    text-align:center;
    padding:10px;
}

</style>
</head>

<body>

<div class="filter-buttons">
    <button onclick="filterSelection('all')">ALL</button>
    <button onclick="filterSelection('lab')">LAB</button>
    <button onclick="filterSelection('class')">CLASS ROOM</button>
    <button onclick="filterSelection('sports')">SPORTS</button>
    <button onclick="filterSelection('events')">EVENTS</button>
</div>

<div class="gallery">

    <div class="gallery-item lab">
        <img src="gallery_images/lab1.jpeg">
        <div class="overlay">LAB</div>
    </div>

    <div class="gallery-item class">
        <img src="gallery_images/class1.jpeg">
        <div class="overlay">CLASS ROOM</div>
    </div>

    <div class="gallery-item sports">
        <img src="gallery_images/sports1.jpg">
        <div class="overlay">SPORTS</div>
    </div>

    <div class="gallery-item events">
        <img src="gallery_images/event1.jpeg">
        <div class="overlay">EVENTS</div>
    </div>

    <div class="gallery-item lab">
        <img src="gallery_images/lab2.jpg">
        <div class="overlay">LAB</div>
    </div>

</div>

<script>

filterSelection("all")

function filterSelection(category) {

    var items = document.getElementsByClassName("gallery-item");

    if(category == "all") category = "";

    for(var i=0; i<items.length; i++){

        items[i].style.display = "none";

        if(items[i].className.indexOf(category) > -1){
            items[i].style.display = "block";
        }
    }
}

</script>

</body>
</html>
