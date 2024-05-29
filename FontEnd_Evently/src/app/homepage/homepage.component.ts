import { Component, OnInit } from '@angular/core';
import { EventService } from '../event.service';

@Component({
  selector: 'app-homepage',
  templateUrl: './homepage.component.html',
  styleUrls: ['./homepage.component.css']
})
export class HomepageComponent implements OnInit {
  token: string | null = null; // Variable to store the token

  externe_data = {
    "Date_Publish": "",
    "newData": ""
  }

  texte = "";
  date = new Date();
  poste = {
    "textPost": "",
    "Date_Publish": ""
  };
  taked :any;
  getid(item : any){
   this.taked=item;
  }


  posts: any;
  private _connect: any;
  firstname: any;

  constructor(private eventService: EventService) {}

  ngOnInit(): void {
    // Get the token from the service
    this.token = this.eventService.getToken();

    // Call getUserName method only if token is available
    
    // Fetch posts
    this.eventService.getPosts().subscribe(
      res => {
        console.log(res);
        this.posts = res;
      },
      err => {
        console.log(err);
      }
    );
  }
  tokenn = this.token;

  createPosts(val: string) {
    console.log(val);
    this.poste.textPost = val;
    this.poste.Date_Publish = this.date.toISOString().slice(0, 10);

    // Attach the token to the post data
    const postDataWithToken = {
      ...this.poste,
      token: this.token // Assuming 'token' is the name of the field expected by the backend
    };

    this.eventService.addPost(postDataWithToken).subscribe(
      res => {
        this.date = new Date();
        val = "";
        this.poste = {
          "textPost": "",
          "Date_Publish": ""
        };
        this.ngOnInit();
      },
      err => {
        console.log(err);
      }
    );
  }

  
  UpdatePosts(val: string) {
    // Add the token, id, and text to the request data
    const updateDataWithTokenAndId = {
      id_Post: this.taked, // Assuming taked holds the id value
      textPost: val,
      token: this.token // Assuming 'token' is the name of the field expected by the backend
    };
  
    this.eventService.putPosts(updateDataWithTokenAndId).subscribe((res: any) => {
      if (res.status === 'success') {
        console.log('Event updated successfully.');
        this.ngOnInit();
      } else {  
        console.error('Error updating event:', res.message);
      }
    });
  }
  
  deletePost(taked: number) {
    if (this.token) {
      this.eventService.deletePost(this.token, taked).subscribe(
        res => {
          console.log('basa');
          console.log("Post deleted successfully", res);
          this.ngOnInit();
        },
        err => {
          console.error("Error deleting post:", err);
        }
      );
    } else {
      console.error("Token is null. Unable to delete post.");
    }
}
}
  
  

