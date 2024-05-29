import { Component } from '@angular/core';
import { EventService } from '../event.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-inscription-component',
  templateUrl: './inscription-component.component.html',
  styleUrls: ['./inscription-component.component.css']
})
export class InscriptionComponentComponent {
    user: any = {
      firstname: '',
      lastname: '',
      email: '',
      password: '',
      password2: '',
      telephone: ''
    };

    errorMessage: string = ''; // Declare errorMessage property

    constructor(private connectService: EventService) {}

    registerUser(): void {
      if (this.user.password !== this.user.password2) {
        console.error('Passwords do not match');
        // Handle password mismatch (e.g., display error to user)
        return;
      }

      this.connectService.registerUser(this.user)
        .subscribe(
          (response: any) => {
            console.log(response.msg); // Handle success response
            // Reset form after successful registration
            this.resetForm();
          },
          (error: any) => {
            console.error('Error:', error); // Handle error response
            this.errorMessage = error.message; // Assign error message to errorMessage property
            // Display error message to user
            // Example: this.errorMessage = 'Registration failed. Please try again.';
          }
        );
    }

    // Reset the form fields to empty strings
    private resetForm(): void {
      this.user = {
        firstname: '',
        lastname: '',
        email: '',
        password: '',
        password2: '',
        telephone: ''
      };
    }
}
