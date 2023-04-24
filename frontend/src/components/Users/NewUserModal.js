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
        gap: theme.spacing(3),
    },
    error: {
        color: theme.palette.error.main,
        marginTop: theme.spacing(1),
    },
    input: {
        width: '100%',
        marginBottom: theme.spacing(2),
    },
    button: {
        marginLeft: theme.spacing(1),
        marginRight: theme.spacing(1),
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
                        className={classes.input}
                    />
                    <TextField
                        label="First Name"
                        value={firstName}
                        onChange={(e) => setFirstName(e.target.value)}
                        required
                        error={!!errors.firstName}
                        helperText={errors.firstName}
                        className={classes.input}
                    />
                    <TextField
                        label="Last Name"
                        value={lastName}
                        onChange={(e) => setLastName(e.target.value)}
                        required
                        error={!!errors.lastName}
                        helperText={errors.lastName}
                        className={classes.input}
                    />
                </form>
            </DialogContent>
            <DialogActions>
                <Button onClick={handleClose} color="secondary" className={classes.button}>
                    Cancel
                </Button>
                <Button onClick={handleSave} color="primary" className={classes.button}>
                    Save
                </Button>
            </DialogActions>
        </Dialog>
    );
}

export default NewUserModal;