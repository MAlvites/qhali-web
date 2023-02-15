
export default {
    formatDate: (value) => {
        const date = new Date(value);
        return ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear();
    },
    capitalice(text){
        let l = text.toLowerCase()
        return text.charAt(0).toUpperCase() + l.slice(1)
    },
}