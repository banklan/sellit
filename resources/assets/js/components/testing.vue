<template>
    <div class="test">
        <!-- <div class="container"> -->
            <!-- <div class="row"> -->
                <!-- <div class="col-md-6 col-md-offset-3"> -->
                    <div class="testing">
                        <div class="central">
                            <h2>This is to test cenratizing div</h2>
                            <h3>This is h3 to still test it</h3>
                            <h4>This is h4 to still test it</h4>
                        </div>
                    </div>
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    </div>
</template>

<style scoped>
    .testing{
        display: flex;
        /* flex-wrap: wrap; */
        justify-content: center;
        align-items: center;
    }
    .central{
        background: rgba(240, 73, 7, 0.973);
        padding: 20px;
        border-radius: 6px;
        border: 1px solid tomato;
        text-align: center;
        flex-basis: 35%;
        height: 300px;

        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin: auto;
    }
    h2, h3, h4{
        color: #fff;
    }

</style>
