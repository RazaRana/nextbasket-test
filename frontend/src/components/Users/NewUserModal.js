import React, { useState } from 'react';
import { makeStyles } from '@material-ui/core/styles';
import {
    Button,
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    TextField,
} from '@material-ui/core';
import {useCreateUser} from "@/components/Users/hooks";

const useStyles = makeStyles((theme) => ({
    form: {
        display: 'flex',
        flexDirection: 'column',
        gap: theme.spacing(2),
    },
}));

function NewUserModal(props) {
    const { isOpen, handleClose } = props;

    const classes = useStyles();

    const {handleSubmit, email, setEmail, firstName, setFirstName,lastName, setLastName} = useCreateUser();

    return (
        <Dialog open={isOpen} onClose={handleClose}>
            <DialogTitle>Create New User</DialogTitle>
            <DialogContent>
                <form className={classes.form} onSubmit={handleSubmit}>
                    <TextField
                        label="Email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                    />
                    <TextField
                        label="First Name"
                        value={firstName}
                        onChange={(e) => setFirstName(e.target.value)}
                        required
                    />
                    <TextField
                        label="Last Name"
                        value={lastName}
                        onChange={(e) => setLastName(e.target.value)}
                        required
                    />
                </form>
            </DialogContent>
            <DialogActions>
                <Button onClick={handleClose} color="secondary">
                    Cancel
                </Button>
                <Button onClick={handleSubmit} color="primary">
                    Save
                </Button>
            </DialogActions>
        </Dialog>
    );
}

export default NewUserModal;
