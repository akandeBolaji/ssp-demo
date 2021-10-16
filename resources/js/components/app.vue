<template>
    <div class="container">
        <div>
            <router-view></router-view>
        </div>
        <FlashMessage></FlashMessage>
    </div>
</template>

<script>
    export default {
        name: "app"
    }
</script>

<style scoped>
html,
body {
    height: 100%;
}

.container {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

