import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import {
    Button,
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    TextField,
} from '@material-ui/core';
import {useCreateUser, useValidateUserCreation} from "@/components/Users/hooks";

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

    const {handleSubmit, email, setEmail, firstName, setFirstName,lastName, setLastName} = useCreateUser({handleClose});

    const {handleSave, errors} = useValidateUserCreation({handleSubmit,email, firstName, lastName});
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
                        error={!!errors.email}
                        helperText={errors.email}
                    />
                    <TextField
                        label="First Name"
                        value={firstName}
                        onChange={(e) => setFirstName(e.target.value)}
                        required
                        error={!!errors.firstName}
                        helperText={errors.firstName}
                    />
                    <TextField
                        label="Last Name"
                        value={lastName}
                        onChange={(e) => setLastName(e.target.value)}
                        required
                        error={!!errors.lastName}
                        helperText={errors.lastName}
                    />
                </form>
            </DialogContent>
            <DialogActions>
                <Button onClick={handleClose} color="secondary">
                    Cancel
                </Button>
                <Button onClick={handleSave} color="primary">
                    Save
                </Button>
            </DialogActions>
        </Dialog>
    );
}

export default NewUserModal;