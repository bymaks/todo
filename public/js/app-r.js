class App extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			itemsTodo: [],
			url:'http://todo.todo/api/all',
			show:-1,
			login: null,
		};
	}

	onActive = event => {
		this.state.url = 'http://todo.todo/api/active';
		this.state.show=0;
		this.componentDidMount();
	};

	onComplite = event => {
		this.state.url = 'http://todo.todo/api/completed';
		this.state.show = 1;
		this.componentDidMount();
	}

	onEnter = event => {
		console.log('enter');
		if (event.key === 'Enter') {
			console.log(event.target.value);
			this.compoentAddItem(event.target.value);
			event.target.value = '';
		}
	}

	onAll = event => {
		console.log('all');
		axios.post('http://todo.todo/api/updateList')
			.then(res => {
				this.state.show=-1;
				const itemsTodo = res.data;
				this.setState({ itemsTodo });
				this.render();
			});

	}

	onUpdateStatus = itemId => {
		console.log('updateStatus');
		axios.post('http://todo.todo/api/updateItem/'+itemId)
			.then(res => {
				this.state.show=-1;
				const itemsTodo = res.data;
				this.setState({ itemsTodo });
				this.render();
			});
	};

	onDeleteItem = itemId => {
		console.log('delete');
		axios.delete('http://todo.todo/api/deleteItem/'+itemId)
			.then(res => {
				this.state.show=-1;
				const itemsTodo = res.data;
				this.setState({ itemsTodo });
			});
	};

	onDeleteList = event => {
		console.log('delete list');
		axios.delete('http://todo.todo/api/deleteComplite')
			.then(res => {
				this.state.show=-1;
				const itemsTodo = res.data;
				this.setState({ itemsTodo });
			});
		this.render();
	};

	compoentAddItem(itemName) {
		axios.post('http://todo.todo/api/addItem/'+itemName)
			.then(res => {
				this.state.show=-1;
				const itemsTodo = res.data;
				this.setState({itemsTodo});
			});
		console.log(this.state.itemsTodo);

	}

	getLogin() {
		axios.get('http://todo.todo/api/namelogin', {})
			.then(res => {
				var login = res.data;
				this.setState({ login: login['login'] });
			});
	}

	onLogin = event => {
		location.replace('/login');
	}

	onLogOut = event =>{
		axios.post('http://todo.todo/api/logout', {})
			.then(res => {
				location.replace('/');
			});
	}
	componentDidMount() {
		this.getLogin();
		axios.get(this.state.url, {})
			.then(res => {
				var itemsTodo = res.data;
				this.setState({ itemsTodo });
			});
		console.log('didMount');
	}

	render() {
		return (<section className="todoapp" id="todoapp">
			<header className="header">
				<h1>todos {this.state.login!=null?this.state.login:''}</h1>
				<input className="new-todo" placeholder="What needs to be done?" autoFocus={true} onKeyDown={ (e)=>this.onEnter(e) }/>
			</header>
			<section className="main">
				<input id="toggle-all" className="toggle-all" type="checkbox" onChange={this.handleChange} onClick={(e)=>this.onAll(e)} />
				<label htmlFor="toggle-all">Mark all as complete</label>
				<ul className="todo-list">
					{ this.state.itemsTodo.map( function liRend(itemTodo, index, a) {
						var LiclassName = ((itemTodo['compliteStatus']==0) ? '' : 'completed');
						var checkedEl  = ((itemTodo['compliteStatus']==0) ? false : true);

						return (<li className={LiclassName} key={index}>
							<div className="view" >
								<input className="toggle" type="checkbox" name={'item-'+index} key={index} checked={checkedEl} onChange={this.handleChange} onClick={(e)=>this.onUpdateStatus(itemTodo['id'])}/>
								<label>{itemTodo['itemName']}</label>
								<button className="destroy" onClick={(e)=>this.onDeleteItem(itemTodo['id'])}></button>
							</div>
						</li>);
					},this)
					}
				</ul>
			</section>
			<footer className="footer">
				<span className="todo-count"><strong>{this.state.itemsTodo.filter(item => item['compliteStatus']==0).length}</strong> item left</span>
				<ul className="filters">
					<li>
						<a className={((this.state.show==-1)?'selected':'' )} id="show-all" href="/">All</a>
					</li>
					<li>
						<a href="#" className={((this.state.show==0)?'selected':'' )} id="show-active" onClick={(e) => this.onActive(e)}>Active</a>
					</li>
					<li>
						<a href="#" className={((this.state.show==1)?'selected':'' )} id="show-complite" onClick={(e) => this.onComplite(e)}>Completed</a>
					</li>
					<li>
						<a href="#" onClick={(((this.state.login!=null))?((e)=>this.onLogOut(e)): ((e)=>this.onLogin(e)) )}>{((this.state.login!=null)?('LogOut'):('LogIn'))}</a>
					</li>
				</ul>
				<button className="clear-completed" onClick={(e)=>this.onDeleteList(e)}>Clear completed</button>
			</footer>
		</section>)
	}
}

ReactDOM.render(<App />, document.getElementById('root'));
