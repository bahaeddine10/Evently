import { Injectable } from '@angular/core';
import { Observable, of, throwError } from 'rxjs';
import { HttpClient, HttpHeaders, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { catchError, map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class EventService {
  private apiUrl = 'http://localhost/';
  private apieventsearch = 'http://localhost/searchevent.php';

  private tokenKey = 'token';// Variable to store the token

  constructor(private http: HttpClient) { }

  private handleError(error: HttpErrorResponse): Observable<any> {
    let errorMessage = 'Unknown error occurred';
    if (error.error instanceof ErrorEvent) {
      errorMessage = `Error: ${error.error.message}`;
    } else {
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    console.error(errorMessage);
    return throwError(errorMessage);
  }

  loginUser(credentials: { email: string, password: string }): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': 'http://localhost:4200'
      }),
      withCredentials: true
    };
    return this.http.post<any>('http://localhost/checkLogin.php', credentials, httpOptions)
    .pipe(
      catchError(this.handleError),
      map(response => {
        if (response && response.token) {
          // Store the token in local storage
          localStorage.setItem(this.tokenKey, response.token);
        }
        return response;
      })
    );
}

  getToken(): string | null {
    return localStorage.getItem(this.tokenKey);
  }

  updateEvent(event: any) {
    return this.http.put(this.apiUrl + 'updatevent.php', event);
  }
  

  deleteEvent(eventName: string): Observable<any> {
    return this.http.post<any>(this.apiUrl + 'deleteevent.php', { eventName: eventName });
  }

  registerUser(user: any): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };

    return this.http.post<any>('http://localhost/signup.php', user, httpOptions)
      .pipe(
        catchError(this.handleError)
      );
  }

  getEvents(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl + 'eventselect.php').pipe(
      catchError(error => {
        console.error('Error fetching events:', error);
        return throwError('Error fetching events');
      })
    );
  }

  addEvent(eventData: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}event.php`, eventData);
  }
  getEventss(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl + 'eventselect.php');
  }

  searchEvents(query: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apieventsearch}?query=${query}`).pipe(
      map((response: any) => {
        if (Array.isArray(response) && response.length === 0) {
          // No results found
          return [];
        } else {
          // Results found
          return response;
        }
      }),
      catchError(error => {
        // Handle errors
        console.error('Error searching events:', error);
        return of([]); // Return empty array in case of error
      })
    );
  }

  addPost(postData: any): Observable<any> {
    return this.http.post<any>(this.apiUrl + 'Pushpost.php', postData);
  }

  getPosts(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl + 'Getpost.php');
  }

  putPosts(data: any): Observable<any> {
    // Retrieve the token from local storage
    const token = localStorage.getItem('token');
    
    // Check if token is not null before including it in the headers
    const httpOptions = token ? {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': 'http://localhost:4200',
        'Token': token
      })
    } : {};
  
    return this.http.put<any>(this.apiUrl + 'updatePost.php', data, httpOptions);
  }
  
  deletePost(token: string, id_Post: number): Observable<any> {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': 'http://localhost:4200'
      })
    };
    const requestBody = { token: token, id_Post: id_Post }; // Create request body
    return this.http.post<any>(`${this.apiUrl}deletePost.php`, requestBody, httpOptions);
  }
  
  
}

