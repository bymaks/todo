class Login extends React.Component{
	constructor(props) {
		super(props);

		this.state = {
			loginForm: {
				login: {
					value: '',
					type: 'text',
					label: 'Login',
					name: 'login',
					placeholder: 'Enter login',
					errorMessage: 'Enter login',
					validation: {
						required: true
					}
				},
				password: {
					value: '',
					type: 'password',
					label: 'Password',
					name: 'passwd',
					placeholder: 'Enter password',
					errorMessage: 'Password',
					validation: {
						required: true
					}
				},
			},
			regForm:{
				login: {
					value: '',
					type: 'text',
					label: 'Login',
					name: 'login',
					placeholder: 'Enter login',
					errorMessage: 'Enter login',
					validation: {
						required: true
					}
				},
				password: {
					value: '',
					type: 'password',
					label: 'Password',
					name: 'passwd',
					placeholder: 'Enter password',
					errorMessage: 'Password',
					validation: {
						required: true
					}
				},
				confirmPassword: {
					value: '',
					type: 'password',
					label: 'Password',
					name: 'confirmPassword',
					placeholder: 'Confirm password',
					errorMessage: 'Confirm password',
					validation: {
						required: true
					}
				},
			},
			regClick:false
		}
	}

	submitHandlerLogin = event => {
		event.preventDefault()
		const {login, password} = this.state.loginForm
		axios.post('http://todo.todo/api/login/'+login.value+'/'+password.value)
			.then(res => {
				if(res.data['status']==true){
					location.replace('/');
				}
				else {
					//показать ошибку
				}
			});

	}

	submitHandlerReg = event => {
		event.preventDefault();
		const formControls =   {...this.state.regForm}
		const {login, password, confirmPassword} = this.state.regForm;
		if(password.value==confirmPassword.value){
			axios.post('http://todo.todo/api/registration/'+login.value+'/'+password.value+'/'+confirmPassword.value)
				.then(res => {
					if(res.data['status']==true){
						location.replace('/');
					}
					else {
						// показать ошибку
					}
				});
		}
		else{
			formControls.confirmPassword.value = '';
			formControls.confirmPassword.errorMessage = 'not equal';
			this.setState({regForm: formControls});
		}


	}

	onChangeHandler = (event, controlName) => {
		const formControls =  (this.state.regClick?{...this.state.regForm}:{...this.state.loginForm});

		const control = {...formControls[controlName]};
		const validate = this.validateControl(event.target.value, control.validation );

		control.value = event.target.value;
		control.valid = validate.status;
		control.touched = true;
		control.errorMessage = (control.errorMessage ? control.errorMessage : validate.errorMessage);

		formControls[controlName] = control;
		if(this.state.regClick){
			this.setState({regForm: formControls})
		}
		else{
			this.setState({loginForm: formControls})
		}

	};

	validateControl(value, validation) {
		const data = {
			'status': true,
			'errorMessage': ''
		};

		if(!validation) {
			return data
		}

		if(validation.required) {
			if(value.trim() === '' && data.status){
				data.status = false
				data.errorMessage = 'not empty'
			}
		}

		return data;
	}

	onClickReg = event => {
		var regFlag  = true;
		if(this.state.regClick){
			regFlag = false;
		}
		this.setState({regClick: regFlag});
	}

	renderInput(inputsForm){
		return Object.keys(inputsForm).map((controlName, index) => {
			const inputProp= inputsForm[controlName];
			return (<input className = "new-todo"
						   key = {controlName + index}
						   type = {inputProp.type}
						   value = {inputProp.value}
						   label = {inputProp.label}
						   placeholder={inputProp.placeholder}
						   errorMessage = {inputProp.errorMessage}
						   required={true}
						   onChange = {event => this.onChangeHandler(event, controlName)}
						   name={inputProp.name}/>)
		})
	}

	renderInputs() {
		return (this.state.regClick?this.renderInput(this.state.regForm):this.renderInput(this.state.loginForm))
	}


	render() {
		return (
			<div className="todoapp" id="todoLoginId">
				<header className = "header">
					<h1>{(this.state.regClick?'Registration':'Login' )}</h1>
				</header>
				<section className = "main" >
					<form onSubmit={(this.state.regClick? ((e)=>this.submitHandlerReg(e)): ((e)=>this.submitHandlerLogin(e)))}>
						{this.renderInputs()}
						<button type="submit" className="button-css">Submit</button>
					</form>
				</section>
				<footer className="footer">

					<ul className="filters">
						<li>
							<a href="#" className={(this.state.regClick?'':'selected' )} onClick={(e)=>this.onClickReg(e)}>login</a>
						</li>
						<li>
							<a href="#" className={(this.state.regClick?'selected':'' )} onClick={(e)=>this.onClickReg(e)}>registratin</a>
						</li>
						<li>
							<a href="/" >todo list</a>
						</li>
					</ul>

				</footer>
			</div>
		)
	}
}

ReactDOM.render(<Login />, document.getElementById('root'));
