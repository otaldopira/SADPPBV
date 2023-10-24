export default {
    formatarCpf(cpf) {
        cpf = cpf.replace(/\D/g, "")
        if (cpf.length > 9) {
            cpf = this.spliceString(cpf, 9, 0, '-')
        }
        if (cpf.length > 6) {
            cpf = this.spliceString(cpf, 6, 0, '.')
        }
        if (cpf.length > 3) {
            cpf = this.spliceString(cpf, 3, 0, '.')
        }
        return cpf
    },
    validarCpf(cpf) {
        cpf = cpf.replace(/[^\d]/g, '')

        if (cpf.length !== 11)
            return false

        if (/^(\d)\1+$/.test(cpf))
            return false

        let soma = 0
        for (let i = 0; i < 9; i++)
            soma += parseInt(cpf.charAt(i)) * (10 - i)

        const resto = (soma * 10) % 11
        const digito1 = (resto === 10 || resto === 11) ? 0 : resto

        soma = 0
        for (let i = 0; i < 10; i++)
            soma += parseInt(cpf.charAt(i)) * (11 - i)

        const resto2 = (soma * 10) % 11
        const digito2 = (resto2 === 10 || resto2 === 11) ? 0 : resto2

        if (parseInt(cpf.charAt(9)) === digito1 && parseInt(cpf.charAt(10)) === digito2)
            return true
        else
            return false
    },
    formatarCelular(celular) {
        celular = celular.replace(/\D/g, "")
        if (celular.length > 7) {
            celular = this.spliceString(celular, 7, 0, '-')
        }
        if (celular.length > 2) {
            celular = this.spliceString(celular, 2, 0, ') ')
        }
        if (celular.length > 0) {
            celular = this.spliceString(celular, 0, 0, '(')
        }
        return celular
    },
    formatarNascimento(nascimento) {
        nascimento = nascimento.replace(/\D/g, "")

        let dia = nascimento.substring(0, 2)
        if (parseInt(dia) > 31) 
            dia = "31"
        
        let mes = nascimento.substring(2, 4)
        if (parseInt(mes) > 12)
            mes = "12"

        nascimento = dia + mes + nascimento.substring(4, nascimento.length+1)
        
        if (nascimento.length > 4) {
            nascimento = this.spliceString(nascimento, 4, 0, '/')
        }
        if (nascimento.length > 2) {
            nascimento = this.spliceString(nascimento, 2, 0, '/')
        }
        return nascimento
    },
    formatarDinheiro(dinheiro) {
        dinheiro = dinheiro.replace(/\D/g, "")

        let aux = dinheiro
        for (let i = 0; i < dinheiro.length; i++)
            if (dinheiro[i] == '0')
                aux = aux.slice(1)
            else break
        dinheiro = aux

        if (dinheiro.length > 2) {
            dinheiro = this.spliceString(dinheiro, dinheiro.length - 2, 0, ',')
        } else if (dinheiro.length == 0) {
            dinheiro = this.spliceString(dinheiro, 0, 0, '')
        } else if (dinheiro.length == 1) {
            dinheiro = this.spliceString(dinheiro, 0, 0, '0,0')
        } else if (dinheiro.length == 2) {
            dinheiro = this.spliceString(dinheiro, 0, 0, '0,')
        }

        if (dinheiro != '')
            dinheiro = 'R$ ' + dinheiro

        return dinheiro
    },
    spliceString(str, index, count, add) {
        let array = str.split("");
        array.splice(index, count, add);
        return array.join("");
    },
}