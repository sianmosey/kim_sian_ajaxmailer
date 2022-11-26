import { SendMail } from "./components/mailer.js";

(() => {
    const { createApp } = Vue

    createApp({
        data() {
            return {
                message: 'Hello Vue!'
            }
        },

        methods: {
            processMailFailure(result) {
                // shows a failure message in the UI
                // use this.$refs to connect to the elements on the page and mark any empty fields/inputs with an error class
                // show some errors in the UI here to let the user know the mail attempt was successful            
                result = JSON.parse(result.message);
                
                this.$refs["emessage"].innerHTML = result.message;
                this.$refs["emessage"].style.display = 'block';
                this.$refs["smessage"].style.display = 'none';
                message.forEach(field => this.$refs[field].classList.add('error'));
                console.log(result)
            },

            processMailSuccess(result) {
                // show a success message in the UI
                // show some UI here to let the user know the mail attempt was successful
                this.$refs["smessage"].innerHTML = result.message;
                this.$refs["smessage"].style.display = 'block';  
                this.$refs["emessage"].style.display = 'none';
                console.log(result)
                
            },

            processMail(event) {  
                this.resetFields();      
                // use the SendMail component to process mail
                SendMail(this.$el.parentNode)
                    .then(data => this.processMailSuccess(data))
                    .catch(err => this.processMailFailure(err));
            }
        }
    }).mount('#mail-form')
})();