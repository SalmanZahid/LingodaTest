import React from 'react'

export default class Loading extends React.Component {
    render() {
        if(!this.props.loading) {
            return <span></span>;
        }
        return <span className='fa-spinner fa-spin'></span>
    }
}