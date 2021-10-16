export default {
    methods : {
        async callApi(method, url, dataObject = false){
            try{
                return await axios({
                    method: method,
                    url: url,
                    data: dataObject
                });
            }catch (error){
                return error.response;
            }
        },

        setFlashMessage(status = 'success',title,message){
            this.$store.state.flashMessage.status = status
            this.$store.state.flashMessage.title = title
            this.$store.state.flashMessage.message = message
        },

        showFlashMessage() {
            let flash = this.$store.state.flashMessage

            if(flash.status) {
                this.flashMessage.show({
                    status: flash.status,
                    title: flash.title,
                    message: flash.message
                });
                this.$store.state.flashMessage.status = false
                this.$store.state.flashMessage.title = false
                this.$store.state.flashMessage.message = false
            }
        }
    }
}
