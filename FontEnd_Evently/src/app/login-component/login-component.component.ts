import { Component } from '@angular/core';
import { EventService } from '../event.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login-component',
  templateUrl: './login-component.component.html',
  styleUrls: ['./login-component.component.css']
})
export class LoginComponentComponent {
  email: string = '';
  password: string = '';
  errorMessage: string = '';

  constructor(private loginService: EventService, private router: Router) { }

  login(): void {
    this.loginService.loginUser({ email: this.email, password: this.password })
      .subscribe(
        (response) => {
          console.log(response);
          // Check if the response contains a token
          if (response && response.token) {
            // Store the token in local storage
            localStorage.setItem('token', response.token);
            // Redirect to the homepage or any desired route
            this.router.navigate(['/Homepage']);
          } else {
            // No token found in the response
            console.error('Login Error: No token found in the response');
            this.errorMessage = 'Invalid credentials. Please try again.';
          }
        },
        (error) => {
          console.error('Login Error:', error);
          this.errorMessage = 'Invalid credentials. Please try again.';
        }
      );
  }
}
