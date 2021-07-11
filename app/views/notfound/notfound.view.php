<link rel="stylesheet" href="css/fawsome.min.css">
<style>
    div.notFound {
        width: 45%;
        height: 250px;
        margin: 0 auto;
        text-align: center;
    }
    div.notFound > div {
        border: 10px solid orange;
        border-top-left-radius: 27px;
        border-top-right-radius: 27px;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        margin-top: 12%;
    }

    div.notFound .square {
        border-bottom: 10px solid orange;
        display: flex;
        margin-bottom: 29px;
    }

    div.notFound .square div {
        border-radius: 50%;
        background: orange;
        margin: 5px;
        width: 30px;
        height: 30px;
    }
    div.notFound div.content {
        width: 100%;
        height: 78%;
        display: flex;
        color: orange;
    }
    div.notFound div.content div.text .error {
        font-size: 70px;
        margin: 45px;
    }
    div.notFound div.content div.text .page {
        font-size: 38px;
    }
</style>
<div class="notFound">
    <div>
        <div class="square">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="content">
            <div class="text">
                <span class="error">404 ERROR</span>
                <br>
                <span class="page">The page is not found</span>
            </div>
            <div>
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>

    </div>
</div>