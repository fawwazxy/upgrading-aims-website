<style>
    :root {
        --secondary: linear-gradient(221deg, #8743ff, #4136f1 60%);
        --card: #eaf2ff;
        --text: #000;
    }

    h1{
        text-transform: uppercase;
    }

    .car-card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        height: 320px;
        margin-bottom: 32px;
        text-align: center;
    }

    .car-card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .car-card img{
        height: 192px;
        width: auto;
        max-width: 95%;
        object-fit: contain;
    }

    .car-container {
        padding: 2px 16px;
        text-align: center;
    }

    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }
    h6 {
        display: flex;
        flex-direction: row;
    }
    h6:before, h6:after{
        content: "";
        flex: 1 1;
        border-bottom: 1px solid;
        margin: auto;
    }
    h6:before {
        margin-right: 5px
    }
    h6:after {
        margin-left: 5px
    }

    .blue {
        background-color: #3498DB;
        border-bottom: 5px solid #2980B9;
        text-shadow: 0 -2px #2980B9;
    }

    .red {
        background-color: #E74C3C;
        border-bottom: 5px solid #BD3E31;
        text-shadow: 0 -2px #BD3E31;
    }

    .green {
        background-color: #82BF56;
        border-bottom: 5px solid #669644;
        text-shadow: 0 -2px #669644;
    }

    .yellow {
        background-color: #F2CF66;
        border-bottom: 5px solid #D1B358;
        text-shadow: 0 -2px #D1B358;
    }

    .boxes {
        background-color: black;
        width: 100%;
        padding: 10px;
        color:white;
        text-align:center;
    }

    .bg-black{
        background-color: black;
        color: white;
    }
</style>