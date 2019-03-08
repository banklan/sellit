<template>
    <div class="test">
        <div class="central">
            <h2>This is to test cenratizing div</h2>
            <h3>This is h3 to still test it</h3>
            <h4>This is h4 to still test it</h4>
        </div>
    </div>
</template>

<style scoped>
    .test{
        position: relative;
    }
    .central{
        background: rgba(240, 73, 7, 0.973);
        width: 400px;
        height: 300px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

</style>

