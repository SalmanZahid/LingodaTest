import  React from 'react';
import  axios from 'axios';
import {NotificationContainer, NotificationManager} from 'react-notifications';

import  {
    POST_CONTACT_URI,
    VALIDATION_ERROR
} from './Constants';
import Loading from './Loading';

import 'react-notifications/lib/notifications.css';

const initialState = {
    name: "",
    email: "",
    message: "",
    loading: false,
    errors: {}
};

export default class ContactForm extends React.Component {
    constructor (props) {
        super(props);
        this.state = initialState;

        this._onError = this._onError.bind(this);
        this._onSuccess = this._onSuccess.bind(this);
        this.hideLoading = this.hideLoading.bind(this);
    };
    _saveInquiry = () => {
        var params = {
            name: this.state.name,
            email: this.state.email,
            message: this.state.message
        };
        // POST REQUEST
        axios({
            url: POST_CONTACT_URI,
            method: 'post',
            data: params,
            headers: {
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*'
            }
        }).then(response => this._onSuccess(response))
            .catch(error => this._onError(error));
    };
    _onSubmit = (e) => {
        e.preventDefault();
        var errors = this._validate();
        if(Object.keys(errors).length !== 0) {
            this.setState({
                errors: errors
            });
            return;
        }
        this._saveInquiry();
    };
    hideLoading = () => this.setState({loading: false});
    _onSuccess = (response) => {
            this.refs.contact_form.reset();
            this.setState(initialState);
            NotificationManager.success("We will contact you shortly with reply to your message","Thank you");
    };
    _onError = (error) => {
        console.log('error', Object.assign({}, error));
        if (error.response === undefined) {
            NotificationManager.error('Unable to find server. Please start server and try again',"Error",3000, () => { });
            return;
        }

        var response = error.response.data;
        // If its a validation error
        if (response.code === VALIDATION_ERROR){
            var errors = {};
            response.errors.map(error => errors[error.property_path] = error.message);
            this.setState({ errors: errors });
            NotificationManager.error('Invalid Fields, Please try again with proper data',"Error",3000, () => { });
        }

        NotificationManager.error('Unable to save your inquiry, Interal Server Error',"Error",3000, () => { });

    };
    _onChange = (e) => {
        var state = { };
        state[e.target.name] = e.target.value;
        this.setState(state);
    };
    _validate = () => {
        var errors = {};

        if(this.state.email === "") {
            errors.email = "Email is required";
        }
        if(this.state.message === "") {
            errors.message = "Message is required";
        }
        return errors;
    };
    _formGroupClass = (field) => {
        var className = "form-group ";
        if(field) {
            className += " has-error"
        }
        return className;
    };
    render() {
        return (
            <div className="form-container">
                <form ref='contact_form' onSubmit={this._onSubmit.bind(this)}>
                    <div className={this._formGroupClass(this.state.errors.name)}>
                        <label className="control-label" for="name">Name </label>
                        <input name="name" ref="name" type="text" className="form-control" id="name" placeholder="Name" onChange={this._onChange} />
                        <span className="help-block error">{this.state.errors.name}</span>
                    </div>
                    <div className={this._formGroupClass(this.state.errors.email)}>
                        <label className="control-label" for="email">Email address</label>
                        <input name="email" ref="email" type="email" className="form-control" id="email" placeholder="Email" onChange={this._onChange} />
                        <span className="help-block error">{this.state.errors.email}</span>
                    </div>
                    <div className={this._formGroupClass(this.state.errors.message)}>
                        <label className="control-label" for="message">Message</label>
                        <textarea name="message" ref="message" type="message" className="form-control" id="message" placeholder="Message" rows="10" onChange={this._onChange} />
                        <span className="help-block error">{this.state.errors.message}</span>
                    </div>
                    <button type="submit" className="btn btn-primary" disabled={this.state.loading}>
                        Submit <Loading loading={this.state.loading} />
                    </button>
                </form>
                <NotificationContainer/>
            </div>
        );
    }
}