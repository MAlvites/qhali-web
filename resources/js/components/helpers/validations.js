import regex from '.././enums/regularExpressions'
import { VARIABLES } from '.././enums/enums'

export default {
    isEmailValid: (value) => {
        let a = value.split('@')
        if(typeof a[1] == "undefined") return false
        let c = a[1].split('.')
        let t = false
        if(a.length > 1){
            let c = a[1].split('.')
            if(c.length <= 4){
                t = true
            }
            c.forEach(e => {
                if(e == "") t = false
            });
        }
        return t && regex.EMAIL.test(value)
    },
    documentNumberType: (doc, value) => {
        if(doc == VARIABLES.DNI){
            return value.length == 8 && !!value.match(regex.ONLY_NUMBERS)
        }
        return true
    },
    isPasswordValid: (value) => {
        return regex.PASSWORD.test(value)
    },
    isOnlyTextValid: (value) => {
        return regex.ONLY_TEXT.test(value)
    }
}