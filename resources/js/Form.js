class Form{
        
    constructor(data){
        this.originalData = data;

        for(let field in data){
            this[field] = data[field];    
        }

        this.errors = new Errors();
    }

    submit(){
        console.log(this.originalData);
    }

}
export default Form;