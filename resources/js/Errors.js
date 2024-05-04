class Errors{
    constructor(){
        this.errors = {};
    }

    has(field){
        if (this.errors[field]) {
            return this.errors.hasOwnProperty(field);
        }
    }

    get(field){
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    any(){
        return Object.keys(this.errors).length > 0;
    }

    record(errors){
        this.errors = errors;
    }

    clear(field){
        if (this.errors[field]) {
            delete this.errors[field];
            return;
        }
        this.errors = {};
    }
}
export default Errors;